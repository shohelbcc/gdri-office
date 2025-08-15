<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use Illuminate\Http\Request;

class BranchController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.branches.index');
    }

    /**
     * Get the resource list.
     */
    public function list()
    {
        $branches = Branch::all();
        try {
            return response()->json(['status' => 'success', 'data' => $branches]);
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
            'name' => 'required|string|max:255|unique:branches,name',
            'location' => 'required|string',
            'phone' => 'required|string',
            'email' => 'required|string',
        ]);

        try {
            $branch = new Branch();
            $branch->name = $request->name;
            $branch->location = $request->location;
            $branch->phone = $request->phone;
            $branch->email = $request->email;
            $branch->save();

            return response()->json(['status' => 'success', 'message' => 'Branch created successfully.']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
        }
    }

    /**
     * Get the specified resource by ID.
     */
    public function byId(Request $request)
    {
        try {
            $branch = Branch::findOrFail($request->id);
            return response()->json([
                'status' => 'success',
                'data' => [
                    'id' => $branch->id,
                    'name' => $branch->name,
                    'location' => $branch->location,
                    'phone' => $branch->phone,
                    'email' => $branch->email,
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Branch $branch)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Branch $branch)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $request->validate([
            'id' => 'required|integer|min:1',
            'name' => 'required|string|max:255|unique:branches,name,' . $request->id,
            'location' => 'required|string',
            'phone' => 'required|string',
            'email' => 'required|string',
        ]);

        try {
            $branch = Branch::findOrFail($request->id);
            $branch->name = $request->name;
            $branch->location = $request->location;
            $branch->phone = $request->phone;
            $branch->email = $request->email;
            $branch->save();

            return response()->json(['status' => 'success', 'message' => 'Branch updated successfully.']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $request->validate([
            'id' => 'required|integer|min:1',
        ]);

        try {
            $branch = Branch::findOrFail($request->id);
            $branch->delete();

            return response()->json(['status' => 'success', 'message' => 'Branch deleted successfully.']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
        }
    }
}
