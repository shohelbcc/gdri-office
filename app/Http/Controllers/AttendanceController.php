<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class AttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $attendances = Attendance::all();
            return view('employee.attendances.index', compact('attendances'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to fetch attendances: ' . $e->getMessage());
        }
    }

    /**
     * Show the form for user list.
     */

    public function list()
    {
        try {
            $attendances = Attendance::with('user')->where('user_id', Auth::id())->get();
            return response()->json(['status' => 'success', 'data' => $attendances]);
        } catch (\Exception $e) {
            return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
        }
    }


    // Admin Functionalities
    public function adminIndex()
    {
        try {
            $attendances = Attendance::all();
            return view('admin.attendances.index', compact('attendances'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to fetch attendances: ' . $e->getMessage());
        }
    }

    /**
     * Show the form for user list.
     */

    public function adminList()
    {
        try {
            $attendances = Attendance::with('user')->get();
            return response()->json(['status' => 'success', 'data' => $attendances]);
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
            'user_id'       => 'required|integer|min:1',
            'date'          => [
                'required',
                'date',
                // Ensure one attendance per user per day
                Rule::unique('attendances')->where(function ($query) use ($request) {
                    return $query->where('user_id', $request->user_id);
                }),
            ],
            'location'      => 'required|string|max:255',
            'check_in'      => 'required|date_format:H:i',
            // late_check_in rule will be added via conditional validator
        ];

        // Create validator instance
        $validator = Validator::make($request->all(), $rules);

        // Conditionally require late_check_in if check_in is after 09:00
        $validator->sometimes('late_check_in', ['required', 'string', 'max:255'], function ($input) {
            return isset($input->check_in) && $input->check_in > '09:00';
        });

        // Otherwise allow late_check_in to be nullable
        $validator->sometimes('late_check_in', ['nullable', 'string', 'max:255'], function ($input) {
            return isset($input->check_in) && $input->check_in <= '09:00';
        });

        // Run validation
        $validator->validate();

        try {
            $user = User::findOrFail($request->user_id);
            $user->attendances()->create([
                'date' => $request->date,
                'location' => $request->location,
                'check_in' => $request->check_in,
                'late_check_in' => $request->late_check_in,
            ]);
            return response()->json(['status' => 'success', 'message' => 'Attendance created successfully']);
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

            $row = Attendance::where('id',$request->id)->with('user')->first();
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
        //
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
        // Base validation rules
        $rules = [
            'location'   => 'required|string|max:255',
            'check_out'  => 'required|date_format:H:i',
            'note'       => 'required|string|max:255',
            // late_check_out rule will be added via conditional validator
        ];

        // Create validator instance
        $validator = Validator::make($request->all(), $rules);

        // Conditionally require late_check_out if check_out is after 09:00
        $validator->sometimes('late_check_out', ['required', 'string', 'max:255'], function ($input) {
            return isset($input->check_out) && $input->check_out > '17:00';
        });

        // Otherwise allow late_check_out to be nullable
        $validator->sometimes('late_check_out', ['nullable', 'string', 'max:255'], function ($input) {
            return isset($input->check_out) && $input->check_out <= '17:00';
        });

        // Run validation
        $validator->validate();

        try {
            $attendance = Attendance::findOrFail($request->updateId);
            $attendance->update([
                'date' => $attendance->date,
                'location' => $request->location,
                'check_in' => $attendance->check_in,
                'late_check_in' => $attendance->late_check_in,

                'check_out' => $request->check_out,
                'late_check_out' => $request->late_check_out,

                'note' => $request->note,
            ]);
            return response()->json(['status' => 'success', 'message' => 'Attendance updated successfully']);
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

            Attendance::where('id', $request->id)->delete();

            return response()->json(['status' => 'success', 'message' => 'Attendance deleted successfully']);
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
            Attendance::whereIn('id', $request->ids)->delete();
            return response()->json(['status' => 'success', 'message' => count($request->ids) . ' Attendance(s) deleted successfully']);
        } catch (\Throwable $th) {
            return response()->json(['status' => 'fail', 'message' => $th->getMessage()]);
        }
    }
}
