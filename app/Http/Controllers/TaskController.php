<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    // For Admin
    // Task Assigned Index
    public function taskAssignedIndex()
    {
        try {
            $users = User::all();
            return view('admin.tasks.index', compact('users'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to fetch notices: ' . $e->getMessage());
        }
    }

    // Task Completed Index
    public function taskCompletedIndex()
    {
        try {
            return view('admin.tasks.completed-index');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to fetch notices: ' . $e->getMessage());
        }
    }

    /**
     * Show the form for user list.
     */
    // Assigned Task List
    public function assignedList()
    {
        try {
            $tasks = Task::whereNot('status', 'Received')->with([
                'assignees:id,name',
                'assigner:id,name' // <-- make sure this is added
            ])->get();
            return response()->json(['status' => 'success', 'data' => $tasks]);
        } catch (\Exception $e) {
            return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
        }
    }

    // Received Task List
    public function completedList()
    {
        try {
            $tasks = Task::where('status', 'Received')->with([
                'assignees:id,name',
                'assigner:id,name' // <-- make sure this is added
            ])->get();
            return response()->json(['status' => 'success', 'data' => $tasks]);
        } catch (\Exception $e) {
            return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
        }
    }


    // For Employee
    // Task Assigned Index
    public function employeeAssignedIndex()
    {
        try {
            return view('employee.tasks.assigned-index');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to fetch notices: ' . $e->getMessage());
        }
    }

    // Task Completed Index
    public function employeeCompletedIndex()
    {
        try {
            return view('employee.tasks.completed-index');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to fetch notices: ' . $e->getMessage());
        }
    }

    /**
     * Show the form for user list.
     */
    // Assigned Task List
    public function employeeAssignedList()
    {
        try {
            $userId = Auth::id();

            $tasks = Task::whereNot('status', 'Received')
                ->whereHas('assignees', function ($query) use ($userId) {
                    $query->where('users.id', $userId);
                })
                ->with([
                    'assignees:id,name',
                    'assigner:id,name'
                ])
                ->get();
            return response()->json(['status' => 'success', 'data' => $tasks]);
        } catch (\Exception $e) {
            return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
        }
    }

    // Received Task List
    public function employeeCompletedList()
    {
        try {
            $userId = Auth::id();

            $tasks = Task::where('status', 'Received')
                ->whereHas('assignees', function ($query) use ($userId) {
                    $query->where('users.id', $userId);
                })
                ->with([
                    'assignees:id,name',
                    'assigner:id,name'
                ])
                ->get();
            return response()->json(['status' => 'success', 'data' => $tasks]);
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
        // Validate incoming request
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'assigned_date' => 'required|date|after_or_equal:today',
            'completed_date' => 'nullable|date|after_or_equal:assigned_date',
            'priority' => 'required|string',
            'project' => 'required|string',
            'assigned_to' => 'required|array', // user IDs
            'assigned_to.*' => 'exists:users,id',
        ]);

        // return response()->json(['status' => 'fail', 'message' => $request->assigned_to]);

        try {
            // Create the task
            $task = Task::create([
                'title' => $validated['title'],
                'description' => $validated['description'],
                'assigned_date' => $validated['assigned_date'],
                'completed_date' => $validated['completed_date'] ?? null,
                'priority' => $validated['priority'],
                'project' => $validated['project'],
                'status' => 'Not Started',
                'assigned_by' => Auth::id(), // assuming authenticated user is the assigner
            ]);

            // Attach assignees to the pivot table
            $task->assignees()->attach($validated['assigned_to']);

            return response()->json(['status' => 'success', 'message' => 'Task created and assigned successfully.']);
        } catch (\Throwable $th) {
            return response()->json(['status' => 'fail', 'message' => $th->getMessage()]);
        }
    }

    /**
     * For Admin
     * Get user by ID.
     */
    public function byId(Request $request)
    {
        try {
            $request->validate([
                'id' => 'required|min:1'
            ]);

            $row = Task::with('assigner', 'assignees:id')->findOrFail($request->id);
            return response()->json(['status' => 'success', 'row' => $row]);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }

    /**
     * For Employee
     * Get user by ID.
     */
    public function employeeById(Request $request)
    {
        try {
            $request->validate([
                'id' => 'required|min:1'
            ]);

            $row = Task::with('assigner', 'assignees:id')->findOrFail($request->id);
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
     * For Admin
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        // Validate incoming request
        $validated = $request->validate([
            'updateId' => 'required|min:1',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'assigned_date' => 'required|date|',
            'completed_date' => 'required|date|after_or_equal:assigned_date',
            'priority' => 'required|string',
            'project' => 'required|string',
            'status' => 'required|string',
            'assigned_to' => 'required|array',
            'assigned_to.*' => 'exists:users,id',
        ]);

        try {
            $task = Task::findOrFail($request->updateId);
            // Update task details
            $task->update([
                'title' => $validated['title'],
                'description' => $validated['description'],
                // 'assigned_date' => $validated['assigned_date'],
                'completed_date' => $validated['completed_date'] ?? null,
                'priority' => $validated['priority'],
                'project' => $validated['project'],
                'status' => $validated['status'],
                // You may or may not want to update the assigner; usually not changed
                // 'assigned_by' => Auth::id(),
            ]);

            // Sync assignees (will remove old and attach new)
            $task->assignees()->sync($validated['assigned_to']);

            return response()->json(['status' => 'success', 'message' => 'Task updated successfully']);
        } catch (\Throwable $th) {
            return response()->json(['status' => 'fail', 'message' => $th->getMessage()]);
        }
    }

    /**
     * For Employee
     * Update the specified resource in storage.
     */
    public function employeeUpdate(Request $request)
    {
        $request->validate([
            'updateId' => 'required|min:1',
            'title' => 'required|string|max:255',
            'status' => 'required|string',
        ]);

        try {
            $task = Task::findOrFail($request->updateId);
            $task->update([
                'status' => $request->status,
            ]);
            return response()->json(['status' => 'success', 'message' => 'Task updated successfully']);
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

            Task::where('id', $request->id)->delete();

            return response()->json(['status' => 'success', 'message' => 'Task deleted successfully']);
        } catch (\Throwable $th) {
            return response()->json(['status' => 'fail', 'message' => $th->getMessage()]);
        }
    }
}
