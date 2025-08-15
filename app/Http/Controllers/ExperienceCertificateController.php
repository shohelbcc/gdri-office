<?php

namespace App\Http\Controllers;

use App\Models\ExperienceCertificate;
use Illuminate\Http\Request;

class ExperienceCertificateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.experience-certificates.index');
    }

    /**
     * Get the resource list.
     */
    public function list()
    {
        try {
            $experienceCertificates = ExperienceCertificate::orderBy('created_at', 'desc')->get();
            return response()->json([
                'status' => 'success',
                'data' => $experienceCertificates
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
            'certificate_number' => 'required|string|max:255|unique:experience_certificates,certificate_number',
            'certificate' => 'required|file|mimes:pdf|max:1024',
        ]);

        try {
            $experienceCertificate = new ExperienceCertificate();
            $experienceCertificate->certificate_number = $request->certificate_number;

            if ($request->hasFile('certificate')) {
                $file = $request->file('certificate');
                $extension = $file->getClientOriginalExtension();
                $location = '/uploads/experience-certificates/';
                $fileName = time() . '.' . $extension;
                $file->move(public_path($location), $fileName);
                $experienceCertificate->certificate = $location . $fileName;
            }

            $experienceCertificate->save();

            return response()->json(['status' => 'success', 'message' => 'Experience certificate created successfully.']);
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
            'id' => 'required|integer|exists:experience_certificates,id',
        ]);

        try {
            $experienceCertificate = ExperienceCertificate::findOrFail($request->id);
            return response()->json([
                'status' => 'success',
                'certificate_number' => $experienceCertificate->certificate_number,
                'certificate' => $experienceCertificate->certificate,
            ]);
        } catch (\Exception $e) {
            return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(ExperienceCertificate $experienceCertificate)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ExperienceCertificate $experienceCertificate)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $request->validate([
            'id' => 'required|integer|exists:experience_certificates,id',
            'certificate_number' => 'required|string|max:255|unique:experience_certificates,certificate_number,' . $request->id,
            'certificate' => 'nullable|file|mimes:pdf|max:1024',
        ]);

        try {
            $experienceCertificate = ExperienceCertificate::findOrFail($request->id);
            $experienceCertificate->certificate_number = $request->certificate_number;

            if ($request->hasFile('certificate')) {
                if ($experienceCertificate->certificate && file_exists(public_path($experienceCertificate->certificate))) {
                    unlink(public_path($experienceCertificate->certificate));
                }
                $file = $request->file('certificate');
                $extension = $file->getClientOriginalExtension();
                $location = '/uploads/experience-certificates/';
                $fileName = time() . '.' . $extension;
                $file->move(public_path($location), $fileName);
                $experienceCertificate->certificate = $location . $fileName;
            }

            $experienceCertificate->save();

            return response()->json(['status' => 'success', 'message' => 'Experience certificate updated successfully.']);
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
            'id' => 'required|integer|exists:experience_certificates,id',
        ]);

        try {
            $experienceCertificate = ExperienceCertificate::findOrFail($request->id);
            // Delete old file if exists
            if ($experienceCertificate->certificate && file_exists(public_path($experienceCertificate->certificate))) {
                unlink(public_path($experienceCertificate->certificate));
            }
            $experienceCertificate->delete();

            return response()->json(['status' => 'success', 'message' => 'Experience certificate deleted successfully.']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
        }
    }

}
