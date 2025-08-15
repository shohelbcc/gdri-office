<?php

namespace App\Http\Controllers;

use App\Models\ProjectTopic;
use Illuminate\Http\Request;

class ProjectTopicController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.project-topics.index');
    }

    /**
     * Get the resource list.
     */
    public function list()
    {
        try {
            $projectTopics = ProjectTopic::orderBy('created_at', 'desc')->get();
            return response()->json(['status' => 'success', 'data' => $projectTopics]);
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
            'name' => 'required|string',
            'description' => 'required|string',
        ]);

        try {
            $projectTopic = new ProjectTopic();
            $projectTopic->name = $request->name;
            $projectTopic->description = $request->description;
            $projectTopic->save();

            return response()->json(['status' => 'success', 'message' => 'Project topic created successfully.']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
        }
    }

    /**
     * Get user by ID.
     */
    public function byId(Request $request)
    {
        try {
            $request->validate([
                'id' => 'required|integer|exists:project_topics,id'
            ]);
            $projectTopic = ProjectTopic::findOrFail($request->id);
            return response()->json([
                'status' => 'success',
                'data' => [
                    'id' => $projectTopic->id,
                    'name' => $projectTopic->name,
                    'description' => $projectTopic->description,
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(ProjectTopic $projectTopic)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProjectTopic $projectTopic)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $request->validate([
            'id' => 'required|integer|exists:project_topics,id',
            'name' => 'required|string',
            'description' => 'required|string',
        ]);
        try {
            $projectTopic = ProjectTopic::findOrFail($request->id);
            $projectTopic->name = $request->name;
            $projectTopic->description = $request->description;
            $projectTopic->save();

            return response()->json(['status' => 'success', 'message' => 'Project topic updated successfully.']);
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
            'id' => 'required|integer|exists:project_topics,id',
        ]);
        try {
            ProjectTopic::where('id', $request->id)->delete();
            return response()->json(['status' => 'success', 'message' => 'Project topic deleted successfully.']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
        }
    }
}
