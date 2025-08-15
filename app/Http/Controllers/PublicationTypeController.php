<?php

namespace App\Http\Controllers;

use App\Models\PublicationType;
use Illuminate\Http\Request;

class PublicationTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.publication-types.index');
    }

    /**
     * Get the resource list.
     */
    public function list()
    {
        try {
            $publicationTypes = PublicationType::orderBy('created_at', 'desc')->get();
            return response()->json(['status' => 'success', 'data' => $publicationTypes]);
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
            'name' => 'required|string|unique:publication_types,name',
            'description' => 'required|string',            
        ]);
        try {
            $publicationType = new PublicationType();
            $publicationType->name = $request->name;
            $publicationType->description = $request->description;
            $publicationType->save();
            return response()->json(['status' => 'success', 'message' => 'Publication type created successfully']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
        }
    }

    /**
     * Get publication type by ID.
     */
    public function byId(Request $request)
    {
        try {
            $request->validate([
                'id' => 'required|integer|exists:publication_types,id'
            ]);
            $publicationType = PublicationType::findOrFail($request->id);
            return response()->json([
                'status' => 'success',
                'data' => [
                    'id' => $publicationType->id,
                    'name' => $publicationType->name,
                    'description' => $publicationType->description,
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(PublicationType $publicationType)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PublicationType $publicationType)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $request->validate([
            'id' => 'required|integer|exists:publication_types,id',
            'name' => 'required|string|unique:publication_types,name,' . $request->id,
            'description' => 'required|string',
        ]);
        try {
            $publicationType = PublicationType::findOrFail($request->id);
            $publicationType->name = $request->name;
            $publicationType->description = $request->description;
            $publicationType->save();
            return response()->json(['status' => 'success', 'message' => 'Publication type updated successfully']);
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
            'id' => 'required|integer|exists:publication_types,id'
        ]);
        try {
            $publicationType = PublicationType::findOrFail($request->id);
            $publicationType->delete();
            return response()->json(['status' => 'success', 'message' => 'Publication type deleted successfully']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
        }
    }
}
