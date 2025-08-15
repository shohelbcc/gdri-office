<?php

namespace App\Http\Controllers;

use App\Models\Partner;
use App\Models\Project;
use App\Models\ProjectTopic;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $partners = Partner::orderBy('created_at', 'desc')->get();
        $topics = ProjectTopic::orderBy('created_at', 'desc')->get();
        return view('admin.projects.index', compact(['partners', 'topics']));
    }

    /**
     * Get the resource list.
     */
    public function list()
    {
        try {
            $projects = Project::with(['partners', 'topics'])->orderBy('created_at', 'desc')->get();
            return response()->json(['status' => 'success', 'data' => $projects, 'count' => $projects->count()]);
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
            'details' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'status' => 'required|string',
            'study_area' => 'required|string',
            'featured_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'partners' => 'array',
            'partners.*' => 'integer|exists:partners,id',
            'topics' => 'array',
            'topics.*' => 'integer|exists:project_topics,id',
        ]);
        try {
            $project = new Project();
            $project->title = $request->title;
            $project->details = $request->details;
            $project->start_date = $request->start_date;
            $project->end_date = $request->end_date;
            $project->status = $request->status;
            $project->study_area = $request->study_area;

            if ($request->hasFile('featured_image')) {
                $file = $request->file('featured_image');
                $extension = $file->getClientOriginalExtension();
                $location = '/uploads/projects/';
                $fileName = time() . '.' . $extension;
                $file->move(public_path($location), $fileName);
                $project->featured_image = $location . $fileName;
            }
            $project->save();
            // Attach partners and topics
            if ($request->has('partners')) {
                $project->partners()->attach($request->partners);
            }
            if ($request->has('topics')) {
                $project->topics()->attach($request->topics);
            }
            return response()->json(['status' => 'success', 'message' => 'Project created successfully.']);
        } catch (\Throwable $th) {
            return response()->json(['status' => 'fail', 'message' => $th->getMessage()]);
        }
    }

    /**
     * Get resource by id.
     */
    public function byId(Request $request)
    {
        try {
            $request->validate([
                'id' => 'required|integer|exists:projects,id'
            ]);
            $project = Project::with(['partners', 'topics'])->findOrFail($request->id);
            return response()->json([
                'status' => 'success',
                'data' => [
                    'id' => $project->id,
                    'title' => $project->title,
                    'details' => $project->details,
                    'start_date' => $project->start_date,
                    'end_date' => $project->end_date,
                    'status' => $project->status,
                    'study_area' => $project->study_area,
                    'featured_image' => $project->featured_image,
                    'partners' => $project->partners->pluck('id'),
                    'topics' => $project->topics->pluck('id'),
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Project $project)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Project $project)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $request->validate([
            'id' => 'required|integer|exists:projects,id',
            'title' => 'required|string|max:255',
            'details' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'status' => 'required|string',
            'study_area' => 'required|string',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'partners' => 'array',
            'partners.*' => 'integer|exists:partners,id',
            'topics' => 'array',
            'topics.*' => 'integer|exists:project_topics,id',
        ]);
        try {
            $project = Project::findOrFail($request->id);
            $project->title = $request->title;
            $project->details = $request->details;
            $project->start_date = $request->start_date;
            $project->end_date = $request->end_date;
            $project->status = $request->status;
            $project->study_area = $request->study_area;

            // Update featured image if exists
            if ($request->hasFile('featured_image')) {
                $file = $request->file('featured_image');
                $extension = $file->getClientOriginalExtension();
                $location = '/uploads/projects/';
                $fileName = time() . '.' . $extension;
                if ($project->featured_image && file_exists(public_path($project->featured_image))) {
                    unlink(public_path($project->featured_image));
                }
                $file->move(public_path($location), $fileName);
                $project->featured_image = $location . $fileName;
            }            
            $project->save();

            // Sync partners and topics
            if ($request->has('partners')) {
                $project->partners()->sync($request->partners);
            }
            if ($request->has('topics')) {
                $project->topics()->sync($request->topics);
            }

            return response()->json(['status' => 'success', 'message' => 'Project updated successfully.']);
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
            'id' => 'required|integer|exists:projects,id'
        ]);
        try {
            $project = Project::findOrFail($request->id);
            if ($project->featured_image && file_exists(public_path($project->featured_image))) {
                unlink(public_path($project->featured_image)); // Delete old file if exists
            }
            $project->delete();
            return response()->json(['status' => 'success', 'message' => 'Project deleted successfully']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
        }
    }
}
