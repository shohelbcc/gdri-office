<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $permissions = Permission::all();
        try {
            return view('admin.permissions.index', compact('permissions'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to fetch permissions: ' . $e->getMessage());
        }
    }

    /**
     * Show the form for user list.
     */

    public function list()
    {
        $permissions = Permission::all();
        try {
            return response()->json(['status' => 'success', 'data' => $permissions]);
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
            'name' => 'required|string|max:255|unique:permissions,name',
        ]);

        try {
            Permission::create([
                'name' => $request->name,
            ]);

            return response()->json(['status' => 'success', 'message' => 'Permission created successfully']);
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

            $row = Permission::findOrFail($request->id);
            return response()->json(['status' => 'success', 'row' => $row]);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Permission $permission)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Permission $permission)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $request->validate([
            'updateId' => 'required|min:1',
            'name' => 'required|string|max:255|unique:permissions,name,' . $request->updateId,
        ]);

        try {
            $permission = Permission::findOrFail($request->updateId);
            $permission->update([
                'name' => $request->name,
            ]);
            return response()->json(['status' => 'success', 'message' => 'Permission updated successfully']);
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

            Permission::where('id', $request->id)->delete();

            return response()->json(['status' => 'success', 'message' => 'Permission deleted successfully']);
        } catch (\Throwable $th) {
            return response()->json(['status' => 'fail', 'message' => $th->getMessage()]);
        }
    }


    /**
     * Bulk delete permissions.
     */
    public function bulkDelete(Request $request)
    {
        $request->validate([
            'ids'   => 'required|array',
            'ids.*' => 'integer|exists:permissions,id',
        ]);

        try {
            Permission::whereIn('id', $request->ids)->delete();
            return response()->json(['status' => 'success', 'message' => count($request->ids) . ' permission(s) deleted successfully']);

        } catch (\Throwable $th) {
            return response()->json(['status' => 'fail', 'message' => $th->getMessage()]);
        }        
    }
}
