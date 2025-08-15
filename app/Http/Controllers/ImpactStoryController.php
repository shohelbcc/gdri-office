<?php

namespace App\Http\Controllers;

use App\Models\ImpactStory;
use Illuminate\Http\Request;

class ImpactStoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            return view('admin.impact-stories.index');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to fetch categories: ' . $e->getMessage());
        }
    }

    /**
     * Get resource list.
     */

    public function list()
    {
        $impactStories = ImpactStory::all();
        try {
            return response()->json(['status' => 'success', 'data' => $impactStories]);
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
            'title' => 'required|string',
            'description' => 'required|string',
            'reference' => 'nullable|string',
        ]);

        try {
            ImpactStory::create([
                'title' => $request->title,
                'description' => $request->description,
                'reference' => $request->reference,
            ]);

            return response()->json(['status' => 'success', 'message' => 'Impact Story created successfully']);
        } catch (\Throwable $th) {
            return response()->json(['status' => 'fail', 'message' => $th->getMessage()]);
        }
    }

    /**
     * Get resource by ID.
     */
    public function byId(Request $request)
    {
        try {
            $request->validate([
                'id' => 'required|min:1'
            ]);

            $row = ImpactStory::findOrFail($request->id);
            return response()->json(['status' => 'success', 'row' => $row]);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(ImpactStory $impactStory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ImpactStory $impactStory)
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
            'title' => 'required|string',
            'description' => 'required|string',
            'reference' => 'nullable|string',
        ]);

        try {
            $category = ImpactStory::findOrFail($request->updateId);
            $category->update([
                'title' => $request->title,
                'description' => $request->description,
                'reference' => $request->reference,
            ]);
            return response()->json(['status' => 'success', 'message' => 'Impact Story updated successfully']);
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

            ImpactStory::where('id', $request->id)->delete();

            return response()->json(['status' => 'success', 'message' => 'Impact Story deleted successfully']);
        } catch (\Throwable $th) {
            return response()->json(['status' => 'fail', 'message' => $th->getMessage()]);
        }
    }
}
