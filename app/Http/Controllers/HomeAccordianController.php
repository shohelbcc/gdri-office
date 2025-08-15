<?php

namespace App\Http\Controllers;

use App\Models\HomeAccordian;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

class HomeAccordianController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $accordianHeader = HomeAccordian::findOrFail(1);
        return view('admin.home-accordians.index', compact('accordianHeader'));
    }

    /**
     * Get the resource list.
     */
    public function list()
    {
        $accordians = HomeAccordian::whereNot('id', 1)->get();
        try {
            return response()->json(['status' => 'success', 'data' => $accordians]);
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
            'content' => 'required|string',
        ]);
        try {
            $accordian = new HomeAccordian();
            $accordian->title = $request->title;
            $accordian->content = $request->input('content');
            $accordian->save();

            return response()->json(['status' => 'success', 'message' => 'Home Accordian created successfully.']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
        }
    }

    /**
     * Get the specified resource by ID.
     */
    public function byId(Request $request)
    {
        $request->validate([
            'id' => 'required|integer|min:1'
        ]);

        try {
            $accordian = HomeAccordian::findOrFail($request->id);
            return response()->json([
                'status' => 'success',
                'data' => [
                    'id' => $accordian->id,
                    'title' => $accordian->title,
                    'content' => $accordian->content,
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function updateHeader(Request $request, $id): RedirectResponse
    {
        $request->validate([
            'title' => 'required|string',
            'content' => 'required|string',
        ]);

        try {
            $accordian = HomeAccordian::findOrFail($id);
            $accordian->title = $request->title;
            $accordian->content = $request->input('content');
            $accordian->save();

            return redirect()->back()->with('success', 'Home Accordian header updated successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to update Home Accordian header: ' . $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(HomeAccordian $homeAccordian)
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
            'title' => 'required|string',
            'content' => 'required|string',
        ]);
        try {
            $accordian = HomeAccordian::findOrFail($request->id);
            $accordian->title = $request->title;
            $accordian->content = $request->input('content');
            $accordian->save();

            return response()->json(['status' => 'success', 'message' => 'Home Accordian updated successfully.']);
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
            'id' => 'required|integer|min:1'
        ]);
        try {
            $accordian = HomeAccordian::findOrFail($request->id);
            $accordian->delete();

            return response()->json(['status' => 'success', 'message' => 'Home Accordian deleted successfully.']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
        }
    }
}
