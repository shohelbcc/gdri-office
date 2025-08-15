<?php

namespace App\Http\Controllers;

use App\Models\Partner;
use Illuminate\Http\Request;

class PartnerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.partners.index');
    }

    /**
     * Get the resource list.
     */
    public function list()
    {
        try {
            $partners = Partner::orderBy('created_at', 'desc')->get();
            return response()->json([
                'status' => 'success',
                'data' => $partners
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'fail',
                'message' => $e->getMessage()
            ]);
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
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'website' => 'nullable|url',
        ]);

        try {
            $partner = new Partner();
            $partner->name = $request->name;
            $partner->description = $request->description;

            if ($request->hasFile('logo')) {
                $file = $request->file('logo');
                $extension = $file->getClientOriginalExtension();
                $location = '/uploads/partners/';
                $fileName = time() . '.' . $extension;
                $file->move(public_path($location), $fileName);
                $partner->logo = $location . $fileName;
            }

            $partner->website = $request->website;
            $partner->save();

            return response()->json(['status' => 'success', 'message' => 'Partner created successfully.']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
        }
    }

    /**
     * Get resource by id.
     */
    public function byId(Request $request)
    {
        $request->validate([
            'id' => 'required|integer|exists:partners,id',
        ]);

        try {
            $partner = Partner::findOrFail($request->id);
            return response()->json([
                'status' => 'success',
                'data' => [
                    'id' => $partner->id,
                    'name' => $partner->name,
                    'description' => $partner->description,
                    'logo' => $partner->logo,
                    'website' => $partner->website,
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Partner $partner)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Partner $partner)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $request->validate([
            'id' => 'required|integer|exists:partners,id',
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'website' => 'nullable|url',
        ]);
        try {
            $partner = Partner::findOrFail($request->id);
            $partner->name = $request->name;
            $partner->description = $request->description;

            if ($request->hasFile('logo')) {
                $file = $request->file('logo');
                $extension = $file->getClientOriginalExtension();
                $location = '/uploads/partners/';
                $fileName = time() . '.' . $extension;
                if ($partner->logo && file_exists(public_path($partner->logo))) {
                    unlink(public_path($partner->logo));
                }
                $file->move(public_path($location), $fileName);
                $partner->logo = $location . $fileName;
            }

            $partner->website = $request->website;
            $partner->save();

            return response()->json(['status' => 'success', 'message' => 'Partner updated successfully.']);
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
            'id' => 'required|integer|exists:partners,id',
        ]);
        try {
            $partner = Partner::findOrFail($request->id);
            if ($partner->logo && file_exists(public_path($partner->logo))) {
                unlink(public_path($partner->logo));
            }
            $partner->delete();

            return response()->json(['status' => 'success', 'message' => 'Partner deleted successfully.']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
        }
    }
}
