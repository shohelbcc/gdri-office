<?php

namespace App\Http\Controllers;

use App\Models\OurStory;
use Illuminate\Http\Request;

class OurStoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, $id)
    {
        $ourStory = OurStory::findOrFail($id);
        return view('admin.our-stories.index', compact('ourStory'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(OurStory $ourStory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'description' => 'required',
        ]);

        $ourStory = OurStory::findOrFail($id);

        try {
            $ourStory->update($request->only('description'));
            return redirect()->back()->with('success', 'Our Story updated successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to update Our Story: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(OurStory $ourStory)
    {
        //
    }
}
