<?php

namespace App\Http\Controllers;

use App\Models\Privacy;
use Illuminate\Http\Request;

class PrivacyController extends Controller
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
        $privacy = Privacy::findOrFail($id);
        return view('admin.privacy.index', compact('privacy'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Privacy $privacy)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string',
            'content' => 'required|string',
        ]);
        try {
            $privacy = Privacy::findOrFail($id);
            $privacy->update($request->all());
            return redirect()->back()->with('success', 'Privacy policy updated successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to update privacy policy: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Privacy $privacy)
    {
        //
    }
}
