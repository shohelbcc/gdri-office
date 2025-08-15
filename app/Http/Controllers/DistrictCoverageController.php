<?php

namespace App\Http\Controllers;

use App\Models\Districtcov;
use App\Models\DistrictCoverage;
use Illuminate\Http\Request;

class DistrictCoverageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $districts = Districtcov::orderBy('name', 'asc')->get();
        return view('admin.district-coverages.index', compact('districts'));
    }

    /**
     * Get the resource list.
     */
    public function list()
    {
        try {
            $districtCoverage = DistrictCoverage::orderBy('name', 'asc')->get();
            return response()->json(['status' => 'success','data' => $districtCoverage]);
        } catch (\Exception $e) {
            return response()->json(['status' => 'fail','message' => $e->getMessage()], 500);
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
            'names' => 'array|required',
        ]);
        try {
            $inserted = [];
            $duplicates = [];
            foreach ($request->names as $name) {
                // Check if already exists
                if (DistrictCoverage::where('name', $name)->exists()) {
                    $duplicates[] = $name;
                    continue;
                }
                DistrictCoverage::create(['name' => $name]);
                $inserted[] = $name;
            }
            if (count($duplicates)) {
                return response()->json([
                    'status' => 'partial',
                    'message' => 'Some districts already exist: ' . implode(', ', $duplicates)
                ]);
            }
            return response()->json(['status' => 'success', 'message' => 'District coverage created successfully.']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'fail', 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Get specific resource by ID.
     */
    public function byId(Request $request)
    {
        $request->validate([
            'id' => 'required|integer|exists:district_coverages,id',
        ]);
        try {
            $districtCoverage = DistrictCoverage::findOrFail($request->id);
            return response()->json([
                'status' => 'success',
                'data' => [
                    'id' => $districtCoverage->id,
                    'name' => $districtCoverage->name,
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json(['status' => 'fail', 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(DistrictCoverage $districtCoverage)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DistrictCoverage $districtCoverage)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $request->validate([
            'id' => 'required|integer|exists:district_coverages,id',
            'name' => 'required|string|max:255',
        ]);
        try {
            $districtCoverage = DistrictCoverage::findOrFail($request->id);
            $districtCoverage->update($request->all());
            return response()->json(['status' => 'success','message' => 'District coverage updated successfully.']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'fail','message' => $e->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $request->validate([
            'id' => 'required|integer|exists:district_coverages,id',
        ]);
        try {
            $districtCoverage = DistrictCoverage::findOrFail($request->id);
            $districtCoverage->delete();
            return response()->json(['status' => 'success','message' => 'District coverage deleted successfully.']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'fail','message' => $e->getMessage()], 500);
        }
    }
}
