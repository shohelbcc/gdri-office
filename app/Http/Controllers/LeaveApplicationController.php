<?php

namespace App\Http\Controllers;

use App\Models\LeaveApplication;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class LeaveApplicationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            return view('employee.leave-applications.index');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to fetch leave application: ' . $e->getMessage());
        }
    }

    /**
     * Show the form for user list.
     */

    public function list()
    {
        try {
            $leaveApplications = LeaveApplication::with('user')->where('user_id', Auth::id())->get();
            return response()->json(['status' => 'success', 'data' => $leaveApplications]);
        } catch (\Exception $e) {
            return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
        }
    }


    // Admin Functionalities
    public function adminIndex()
    {
        try {
            return view('admin.leave-applications.index');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to fetch leave application: ' . $e->getMessage());
        }
    }

    /**
     * Show the form for user list.
     */

    public function adminList()
    {
        try {
            $leaveApplications = LeaveApplication::with('user')->get();
            return response()->json(['status' => 'success', 'data' => $leaveApplications]);
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
        // Base validation rules
        $rules = [
            'user_id'       => 'required|min:1',
            'start_date' => ['required', 'date','after_or_equal:today'],
            'end_date' => ['required', 'date','after_or_equal:start_date'],
            'type' => ['required', 'string'],
            'reason' => ['required', 'string'],
            'signature' => ['required', 'image', 'mimes:jpg,jpeg,png', 'max:1024'],
            'apply_date'          => [
                'required',
                'date',
                // Ensure one attendance per user per day
                Rule::unique('leave_applications')->where(function ($query) use ($request) {
                    return $query->where('user_id', $request->user_id);
                }),
            ],
        ];

        // Create validator instance
        $validator = Validator::make($request->all(), $rules);

        // Run validation
        $validator->validate();

        try {
            $user = User::findOrFail($request->user_id);
            if ($request->hasFile('signature')) {
                $file = $request->file('signature');
                $extention = $file->getClientOriginalExtension();
                $location = 'uploads/leave-applications/';
                $fileName = time() . '.' . $extention;

                $file->move(public_path($location), $fileName);

                $user->leave_applications()->create([
                    'apply_date' => $request->apply_date,
                    'start_date' => $request->start_date,
                    'end_date' => $request->end_date,
                    'total_days' => (strtotime($request->end_date) - strtotime($request->start_date)) / (60 * 60 * 24) + 1,
                    'type' => $request->type,
                    'reason' => $request->reason,
                    'signature' => $location . $fileName,
                ]);
            }

            return response()->json(['status' => 'success', 'message' => 'Leave Application created successfully']);
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

            $row = LeaveApplication::where('id', $request->id)->with('user')->first();
            return response()->json(['status' => 'success', 'row' => $row]);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $application = LeaveApplication::with('user')->findOrFail($id);
        return view('employee.leave-applications.application', compact('application'));
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
            'updateId' => ['required', 'min:1'],
            'apply_date' => ['required', 'date'],
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date'],
            'type' => ['required', 'string'],
            'reason' => ['required', 'string'],
            'signature' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:1024'],
        ]);

        try {
            $leaveApplications = LeaveApplication::findOrFail($request->updateId);

            if ($request->hasFile('signature')) {
                $file = $request->file('signature');
                $extention = $file->getClientOriginalExtension();
                $location = 'uploads/leave-applications/';
                $fileName = time() . '.' . $extention;

                // Delete Old File
                $filePath = public_path($leaveApplications->signature);
                if (file_exists($filePath)) {
                    File::delete($filePath);
                }

                // New File Aadd
                $file->move(public_path($location), $fileName);

                $leaveApplications->update([
                    'apply_date' => $request->apply_date,
                    'start_date' => $request->start_date,
                    'end_date' => $request->end_date,
                    'total_days' => (strtotime($request->end_date) - strtotime($request->start_date)) / (60 * 60 * 24) + 1,
                    'type' => $request->type,
                    'reason' => $request->reason,
                    'signature' => $location . $fileName,
                ]);
            } else {
                $leaveApplications->update([
                    'apply_date' => $request->apply_date,
                    'start_date' => $request->start_date,
                    'end_date' => $request->end_date,
                    'type' => $request->type,
                    'reason' => $request->reason,
                ]);
            }

            return response()->json(['status' => 'success', 'message' => 'Leave Application updated successfully']);
        } catch (\Throwable $th) {
            return response()->json(['status' => 'fail', 'message' => $th->getMessage()]);
        }
    }

    // Update by Admin
    public function updateByAdmin(Request $request)
    {
        $request->validate([
            'updateId' => ['required', 'min:1'],
            'status' => ['required', 'string'],
        ]);

        try {
            $leaveApplications = LeaveApplication::findOrFail($request->updateId);

            $leaveApplications->update([
                    'status' => $request->status,
                ]);

            return response()->json(['status' => 'success', 'message' => 'Leave Application updated successfully']);
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

            $leaveApplication = LeaveApplication::findOrFail($request->id);

            // Delete Old File
            $filePath = public_path($leaveApplication->signature);
            if (file_exists($filePath)) {
                File::delete($filePath);
            }

            $leaveApplication->delete();

            return response()->json(['status' => 'success', 'message' => 'Leave Application deleted successfully']);
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
            'ids.*' => 'integer|exists:attendances,id',
        ]);

        try {
            LeaveApplication::whereIn('id', $request->ids)->delete();
            return response()->json(['status' => 'success', 'message' => count($request->ids) . ' Leave Application(s) deleted successfully']);
        } catch (\Throwable $th) {
            return response()->json(['status' => 'fail', 'message' => $th->getMessage()]);
        }
    }
}
