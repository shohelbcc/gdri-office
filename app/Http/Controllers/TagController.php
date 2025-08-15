<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            return view('admin.blogs.tags.index');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to fetch tags: ' . $e->getMessage());
        }
    }

    /**
     * Show the form for user list.
     */

    public function list()
    {
        $tags = Tag::all();
        try {
            return response()->json(['status' => 'success', 'data' => $tags]);
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
            'name' => 'required|string|max:255|unique:tags,name',
        ]);

        try {
            $slug = Str::slug($request->name);
            Tag::create([
                'name' => $request->name,
                'slug' => $slug,
            ]);

            return response()->json(['status' => 'success', 'message' => 'Tag created successfully']);
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

            $row = Tag::findOrFail($request->id);
            return response()->json(['status' => 'success', 'row' => $row]);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Tag $tag)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tag $tag)
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
            'name' => 'required|string|max:255|unique:tags,name,' . $request->updateId,
        ]);

        try {
            $slug = Str::slug($request->name);
            $tag = Tag::findOrFail($request->updateId);
            $tag->update([                
                'name' => $request->name,
                'slug' => $slug,
            ]);
            return response()->json(['status' => 'success', 'message' => 'Tag updated successfully']);
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

            Tag::where('id', $request->id)->delete();

            return response()->json(['status' => 'success', 'message' => 'Tag deleted successfully']);
        } catch (\Throwable $th) {
            return response()->json(['status' => 'fail', 'message' => $th->getMessage()]);
        }
    }
}
