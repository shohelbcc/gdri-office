<?php

namespace App\Http\Controllers;

use App\Models\ProjectTopic;
use App\Models\Publication;
use App\Models\PublicationType;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PublicationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        
        $projectTopics = ProjectTopic::with('publications')
            ->orderBy('name', 'desc')
            ->get();
        $publicationTypes = PublicationType::with('publications')
            ->orderBy('name', 'desc')
            ->get();
        return view('admin.publications.index', compact(['projectTopics', 'publicationTypes']));
    }

    /**
     * Get the resource list.
     */
    public function list()
    {
        try {
            $publications = Publication::with(['projectTopic', 'publicationType'])
                ->orderBy('created_at', 'desc')
                ->get();
            return response()->json(['status' => 'success', 'data' => $publications]);
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
            'description' => 'required|string',
            'publication_type_id' => 'required|exists:publication_types,id',
            'project_topic_id' => 'required|exists:project_topics,id',
            'authors' => 'required|string',
            'published_year' => 'required|integer',
            'link' => 'nullable|url',
            'paper_type' => 'nullable|string',
        ]);
        try {
            $slug = Str::slug($request->title);
            $publication = new Publication();
            $publication->title = $request->title;
            $publication->description = $request->description;
            $publication->publication_type_id = $request->publication_type_id;
            $publication->project_topic_id = $request->project_topic_id;
            $publication->authors = $request->authors;
            $publication->published_year = $request->published_year;
            $publication->link = $request->link;
            $publication->paper_type = $request->paper_type;
            $publication->slug = $slug;
            $publication->save();
            return response()->json(['status' => 'success', 'message' => 'Publication created successfully']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
        }
    }

    /**
     * Get publication by ID.
     */
    public function byId(Request $request)
    {
        try {
            $request->validate([
                'id' => 'required|integer|exists:publications,id'
            ]);
            $publication = Publication::with(['projectTopic', 'publicationType'])
                ->findOrFail($request->id);
            return response()->json([
                'status' => 'success',
                'data' => [
                    'id' => $publication->id,
                    'title' => $publication->title,
                    'description' => $publication->description,
                    'publication_type_id' => $publication->publication_type_id,
                    'project_topic_id' => $publication->project_topic_id,
                    'authors' => $publication->authors,
                    'published_year' => $publication->published_year,
                    'link' => $publication->link,
                    'paper_type' => $publication->paper_type,
                    'slug' => $publication->slug,
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Publication $publication)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Publication $publication)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $request->validate([
            'id' => 'required|integer|exists:publications,id',
            'title' => 'required|string',
            'description' => 'required|string',
            'publication_type_id' => 'required|exists:publication_types,id',
            'project_topic_id' => 'required|exists:project_topics,id',
            'authors' => 'required|string',
            'published_year' => 'required|integer',
            'link' => 'nullable|url',
            'paper_type' => 'nullable|string',
            'slug' => 'nullable|string|unique:publications,slug,' . $request->id
        ]);
        try {
            $slug = Str::slug($request->title);
            $publication = Publication::findOrFail($request->id);
            $publication->title = $request->title;
            $publication->description = $request->description;
            $publication->publication_type_id = $request->publication_type_id;
            $publication->project_topic_id = $request->project_topic_id;
            $publication->authors = $request->authors;
            $publication->published_year = $request->published_year;
            $publication->link = $request->link;
            $publication->paper_type = $request->paper_type;
            $publication->slug = $slug;
            $publication->save();
            return response()->json(['status' => 'success', 'message' => 'Publication updated successfully']);
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
            'id' => 'required|integer|exists:publications,id'
        ]);
        try {
            $publication = Publication::findOrFail($request->id);
            $publication->delete();
            return response()->json(['status' => 'success', 'message' => 'Publication deleted successfully.']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
        }
    }
}
