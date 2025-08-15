<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (Auth::user()->hasRole("super admin")) {
            $roles = Role::whereNotIn("name", ['super admin', Auth::user()->roles->pluck("name")])->get();
        } else {
            $roles = Role::whereNotIn("name", ['super admin', 'admin', Auth::user()->roles->pluck("name")])->get();
        }

        try {
            return view('admin.roles.index', compact('roles'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to fetch roles: ' . $e->getMessage());
        }
    }

    /**
     * Show the form for user list.
     */

    public function list()
    {
        $roles = Role::all();
        try {
            return response()->json(['status' => 'success', 'data' => $roles]);
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
            'name' => 'required|string|max:255|unique:roles,name',
        ]);

        try {
            Role::create([
                'name' => $request->name,
            ]);

            return response()->json(['status' => 'success', 'message' => 'Role created successfully']);
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

            $row = Role::findOrFail($request->id);
            return response()->json(['status' => 'success', 'row' => $row]);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Role $role)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Role $role)
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
            'name' => 'required|string|max:255|unique:roles,name,' . $request->updateId,
        ]);

        try {
            $role = Role::findOrFail($request->updateId);
            $role->update([
                'name' => $request->name,
            ]);
            return response()->json(['status' => 'success', 'message' => 'Role updated successfully']);
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

            Role::where('id', $request->id)->delete();

            return response()->json(['status' => 'success', 'message' => 'Role deleted successfully']);
        } catch (\Throwable $th) {
            return response()->json(['status' => 'fail', 'message' => $th->getMessage()]);
        }
    }


    /**
     * Bulk delete roles.
     */
    public function bulkDelete(Request $request)
    {
        $request->validate([
            'ids'   => 'required|array',
            'ids.*' => 'integer|exists:users,id',
        ]);

        try {
            Role::whereIn('id', $request->ids)->delete();
            return response()->json(['status' => 'success', 'message' => count($request->ids) . ' role(s) deleted successfully']);
        } catch (\Throwable $th) {
            return response()->json(['status' => 'fail', 'message' => $th->getMessage()]);
        }
    }

    // Assign Permission to Role
    public function assignPermission(Request $request, $id)
    {
        // 1) Load the target role
        $role = Role::findOrFail($id);

        $userRoles = Auth::user()->roles;

        // 2) IDs of permissions already assigned to THIS role
        $userPermissionIds = $userRoles
        ->load('permissions')                     // eager load permissions
        ->pluck('permissions')                    // collection of collections
        ->flatten()                               // single collection of Permission models
        ->pluck('id')                             // get only IDs
        ->unique()                                // remove duplicates
        ->toArray();

        // 3) Names of permissions you always want to exclude
        $excludedNames = [
            'Edit-role',
            'Delete-role',
            'Bulk-delete-role',
            'View-permission',
            'Create-permission',
            'Edit-permission',
            'Delete-permission',
            'Bulk-delete-permission',
            'Bulk-delete-user',
        ];

        //    → get their IDs
        $excludedIds = Permission::whereIn('name', $excludedNames) // এখানে সমস্যা
            ->pluck('id')
            ->toArray();


        // 4) Fetch all permissions whose IDs are *not* in either list
        $permissions = Permission::whereNotIn(
            'id',
            array_merge($userPermissionIds, $excludedIds)
        )->get();

        return view('admin.roles.assign-permissions.index', compact('permissions', 'role'));
    }

    public function assignPermissionStore(Request $request, $id)
    {
        // 1. Validate incoming data
        $data = $request->validate([
            'permissions'   => ['required', 'array'],
            'permissions.*' => ['integer', 'exists:permissions,id'],
        ]);

        // 2. Retrieve the role (404 if not found)
        $role = Role::findOrFail($id);

        // 2. sync will attach & detach as needed
        $role->permissions()->sync($request->input('permissions', []));

        // 4. Redirect (or return JSON) with a success message
        return redirect()->back()->with('success', 'Permissions assigned successfully.');
    }


    // Assign Role to User
    public function assignRole(Request $request, $id)
    {
        if (Auth::user()->hasRole("super admin")) {
            $roles = Role::whereNotIn("name", ['super admin', Auth::user()->roles->pluck("name")])->get();
        } else {
            $roles = Role::whereNotIn("name", ['super admin', 'admin', Auth::user()->roles->pluck("name")])->get();
        }
        $user = User::findOrFail($id);
        try {
            return view('admin.roles.assign-roles.index', compact('roles', 'user'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to fetch roles: ' . $e->getMessage());
        }
    }

    public function assignRoleStore(Request $request, $id)
    {
        // 1. Validate incoming data
        $data = $request->validate([
            'roles'   => ['required', 'array'],
            'roles.*' => ['integer', 'exists:roles,id'],
        ]);

        // 2. Retrieve the role (404 if not found)
        $user = User::findOrFail($id);

        // 2. sync will attach & detach as needed
        $user->roles()->sync($request->input('roles', []));

        // 4. Redirect (or return JSON) with a success message
        return redirect()->back()->with('success', 'Role(s) assigned successfully.');
    }
}
