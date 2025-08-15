<?php

namespace App\Http\Controllers;

use App\Models\Notice;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class NoticeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    // For Admin
    public function index()
    {
        try {
            $users = User::where('user_type', 'employee')
                ->orderBy('name', 'asc')
                ->get();
            return view('admin.notices.index', compact('users'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to fetch notices: ' . $e->getMessage());
        }
    }

    // For Employee
    public function employeeIndex()
    {
        try {
            return view('employee.notices.index');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to fetch notices: ' . $e->getMessage());
        }
    }

    /**
     * Show the form for user list.
     */

    public function list()
    {
        try {
            $notices = Notice::with('users')->orderBy('created_at', 'desc')->get();

            // Add debug logging
            Log::info('Notice list requested', ['count' => $notices->count()]);

            return response()->json([
                'status' => 'success',
                'data' => $notices,
                'count' => $notices->count()
            ]);
        } catch (\Exception $e) {
            Log::error('Notice list error: ' . $e->getMessage());
            return response()->json([
                'status' => 'fail',
                'message' => $e->getMessage(),
                'error' => 'Database error occurred'
            ], 500);
        }
    }

    /**
     * Show employee notice list with read status
     */
    public function employeeList()
    {
        try {
            $user = Auth::user();
            $notices = $user->notices()
                ->whereNotNull('published_at')
                ->where('published_at', '<=', now())
                ->orderBy('created_at', 'asc')
                ->get()
                ->map(function ($notice) use ($user) {
                    $notice->has_read = $notice->isReadBy($user);
                    return $notice;
                });

            return response()->json(['status' => 'success', 'data' => $notices]);
        } catch (\Exception $e) {
            return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'details' => 'required|string',
            'published_at' => 'required|date',
            'user_ids' => 'required|array',
            'user_ids.*' => 'integer|exists:users,id',
        ]);

        try {
            $notice = Notice::create([
                'title' => $request->title,
                'details' => $request->details,
                'published_at' => $request->published_at,
            ]);

            // Attach users to the notice
            $notice->users()->attach($request->user_ids);

            return response()->json(['status' => 'success', 'message' => 'Notice created successfully']);
        } catch (\Throwable $th) {
            return response()->json(['status' => 'fail', 'message' => $th->getMessage()]);
        }
    }

    /**
     * Get user by ID.
     */
    public function byId(Request $request)
    {
        try {
            $request->validate([
                'id' => 'required|min:1'
            ]);

            $row = Notice::with('users')->findOrFail($request->id);
            return response()->json(['status' => 'success', 'row' => $row]);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }

    /**
     * Mark notice as read
     */
    public function markAsRead(Request $request)
    {
        try {
            $request->validate([
                'notice_id' => 'required|integer|min:1'
            ]);

            $user = Auth::user();
            $user->markNoticeAsRead($request->notice_id);

            return response()->json(['status' => 'success', 'message' => 'Notice marked as read']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'details' => 'required|string',
            'published_at' => 'required|date',
            'user_ids' => 'required|array',
            'user_ids.*' => 'integer|exists:users,id',
        ]);

        try {
            $notice = Notice::findOrFail($request->updateId);
            $notice->update([
                'title' => $request->title,
                'details' => $request->details,
                'published_at' => $request->published_at,
            ]);
            // Sync users with the notice
            $notice->users()->sync($request->user_ids);
            return response()->json(['status' => 'success', 'message' => 'Notice updated successfully']);
        } catch (\Throwable $th) {
            return response()->json(['status' => 'fail', 'message' => $th->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        try {

            Notice::where('id', $request->id)->delete();

            return response()->json(['status' => 'success', 'message' => 'Notice deleted successfully']);
        } catch (\Throwable $th) {
            return response()->json(['status' => 'fail', 'message' => $th->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function bulkDelete(Request $request)
    {
        $request->validate([
            'ids'   => 'required|array',
            'ids.*' => 'integer|exists:notices,id',
        ]);

        try {
            Notice::whereIn('id', $request->ids)->delete();
            return response()->json(['status' => 'success', 'message' => count($request->ids) . ' Notice(s) deleted successfully']);
        } catch (\Throwable $th) {
            return response()->json(['status' => 'fail', 'message' => $th->getMessage()]);
        }
    }

    /**
     * Get unread notice count for employee (AJAX)
     */
    public function unreadCount()
    {
        $user = Auth::user();
        $count = $user->getUnreadNoticesCount();
        return response()->json(['count' => $count]);
    }
}
