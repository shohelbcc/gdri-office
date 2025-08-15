<?php

namespace App\Http\Controllers;

use App\Models\WhyGdri;
use Illuminate\Http\Request;

class WhyGdriController extends Controller
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
        $whyGdri = WhyGdri::findOrFail($id);
        return view('admin.why-gdris.index', compact('whyGdri'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(WhyGdri $whyGdri)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
        ]);

        $whyGdri = WhyGdri::findOrFail($id);

        try {
            $whyGdri->update($request->only('title', 'description'));
            return redirect()->back()->with('success', 'Why GDRI updated successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to update Why GDRI: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(WhyGdri $whyGdri)
    {
        //
    }
}
