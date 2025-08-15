<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.services.index');
    }
    /**
     * Get the resource list.
     */
    public function list()
    {
        try {
            $services = Service::orderBy('created_at', 'desc')->get();
            return response()->json(['status' => 'success','data' => $services,'count' => $services->count()]);
        } catch (\Exception $e) {
            return response()->json(['status' => 'fail','message' => $e->getMessage()]);
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
            'description' => 'required|string',
            'banner' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'status' => 'required|string',
        ]);

        try {
            $service = new Service();
            $service->title = $request->title;
            $service->description = $request->description;
            $service->status = $request->status;

            if ($request->hasFile('banner')) {
                $file = $request->file('banner');
                $extension = $file->getClientOriginalExtension();
                $location = '/uploads/services/';
                $fileName = time() . '.' . $extension;
                $file->move(public_path($location), $fileName);
                $service->banner = $location . $fileName;
            }

            $service->save();

            return response()->json(['status' => 'success', 'message' => 'Service created successfully.']);
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
            'id' => 'required|integer|exists:services,id'
        ]);
        try {
            $service = Service::findOrFail($request->id);
            return response()->json([
                'status' => 'success',
                'data' => [
                    'id' => $service->id,
                    'title' => $service->title,
                    'description' => $service->description,
                    'banner' => $service->banner,
                    'status' => $service->status,
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Service $service)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Service $service)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $request->validate([
            'id' => 'required|integer|exists:services,id',
            'title' => 'required|string',
            'description' => 'required|string',
            'banner' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'status' => 'required|string',
        ]);

        try {
            $service = Service::findOrFail($request->id);
            $service->title = $request->title;
            $service->description = $request->description;
            $service->status = $request->status;

            if ($request->hasFile('banner')) {
                $file = $request->file('banner');
                $extension = $file->getClientOriginalExtension();
                $location = '/uploads/services/';
                $fileName = time() . '.' . $extension;
                if ($service->banner && file_exists(public_path($service->banner))) {
                    unlink(public_path($service->banner)); // Delete old file if exists
                }
                $file->move(public_path($location), $fileName);
                $service->banner = $location . $fileName;
            }

            $service->save();

            return response()->json(['status' => 'success', 'message' => 'Service updated successfully.']);
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
            'id' => 'required|integer|exists:services,id'
        ]);

        try {
            $service = Service::findOrFail($request->id);
            if ($service->banner && file_exists(public_path($service->banner))) {
                unlink(public_path($service->banner)); // Delete old file if exists
            }
            $service->delete();

            return response()->json(['status' => 'success', 'message' => 'Service deleted successfully.']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
        }
    }
}
