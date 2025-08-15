<?php

namespace App\Http\Controllers;

use App\Models\Author;
use Illuminate\Http\Request;

class AuthorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            return view('admin.blogs.authors.index');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to fetch authors: ' . $e->getMessage());
        }
    }

    /**
     * Show the form for user list.
     */

    public function list()
    {
        $authors = Author::all();
        try {
            return response()->json(['status' => 'success', 'data' => $authors]);
        } catch (\Exception $e) {
            return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:authors,email',
        ]);

        try {
            Author::create([
                'name' => $request->name,
                'email' => $request->email,
            ]);

            return response()->json(['status' => 'success', 'message' => 'Author created successfully']);
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

            $row = Author::findOrFail($request->id);
            return response()->json(['status' => 'success', 'row' => $row]);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Author $author)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Author $author)
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
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:authors,email,' . $request->updateId,
        ]);

        try {
            $author = Author::findOrFail($request->updateId);
            $author->update([                
                'name' => $request->name,
                'email' => $request->email,
            ]);
            return response()->json(['status' => 'success', 'message' => 'Author updated successfully']);
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

            Author::where('id', $request->id)->delete();

            return response()->json(['status' => 'success', 'message' => 'Author deleted successfully']);
        } catch (\Throwable $th) {
            return response()->json(['status' => 'fail', 'message' => $th->getMessage()]);
        }
    }
}
