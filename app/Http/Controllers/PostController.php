<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Models\BlogCategory;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $tags = Tag::orderBy('name')->get();
            $categories = BlogCategory::orderBy('name')->get();
            $authors = Author::orderBy('name')->get();
            return view('admin.blogs.posts.index', compact(['tags', 'categories', 'authors']));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to fetch posts: ' . $e->getMessage());
        }
    }

    /**
     * Show the form for user list.
     */

    public function list()
    {
        $posts = Post::with(['blog_category', 'tags', 'authors', 'createdBy'])->get();
        try {
            return response()->json(['status' => 'success', 'data' => $posts]);
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
        // Validate incoming data
        $validated = $request->validate([
            'title'            => 'required|string|max:255|unique:posts,title',
            'excerpt'          => 'nullable|string|max:1000',
            'content'          => 'required|string',
            'blog_category_id' => 'required|exists:blog_categories,id',
            'authors'          => 'nullable|array',
            'authors.*'        => 'exists:authors,id',
            'tags'             => 'nullable|array',
            'tags.*'           => 'exists:tags,id',
            'status'           => 'required|string|in:draft,published',
            'published_at'     => 'nullable|date',
            'featured_image'   => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        try {
            // Handle featured image upload
            $fileName = null;
            $fileWithLocaton = null;
            if ($request->hasFile('featured_image')) {
                // This will store in storage/app/public/posts/
                $file = $request->file('featured_image');
                $fileLocation = 'uploads/posts/';
                $fileExtention = $file->getClientOriginalExtension();
                $fileName = time() . '.' . $fileExtention;
                $fileWithLocaton = $fileLocation.$fileName;

                $file->move(public_path($fileLocation), $fileName);
            }

            $slug = Str::slug($request->title);
            // Create the post
            $post = Post::create([
                'title'            => $validated['title'],
                'slug'             => $slug,
                'excerpt'          => $validated['excerpt'] ?? null,
                'content'          => $validated['content'],
                'blog_category_id' => $validated['blog_category_id'],
                'status'           => $validated['status'],
                'published_at'     => $validated['published_at'] ?? null,
                'featured_image'   => $fileWithLocaton,
                'created_by'       => Auth::id(),
            ]);

            // Attach tags (many-to-many)
            if (!empty($validated['tags'])) {
                $post->tags()->attach($validated['tags']);
            }

            // Attach authors (many-to-many via post_author pivot)
            if (!empty($validated['authors'])) {
                $post->authors()->attach($validated['authors']);
            }

            return response()->json(['status' => 'success', 'message' => 'Post created successfully']);
        } catch (\Throwable $th) {
            return response()->json(['status' => 'fail', 'message' => $th->getMessage()]);
        }
    }    

    /**
     * Get user by ID.
     */
    public function byId(Request $request)
    {
        try {
            $request->validate([
                'id' => 'required|min:1'
            ]);

            $row = Post::where('id', $request->id)->with(['blog_category', 'tags', 'authors', 'createdBy'])->first();
            return response()->json(['status' => 'success', 'row' => $row]);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        // Validate incoming data
        $validated = $request->validate([
            'updateId'         => ['required', 'min:1'],
            'title'            => 'required|string|max:255|unique:posts,title,'.$request->updateId,
            'excerpt'          => 'nullable|string|max:1000',
            'content'          => 'required|string',
            'blog_category_id' => 'required|exists:blog_categories,id',
            'authors'          => 'nullable|array',
            'authors.*'        => 'exists:authors,id',
            'tags'             => 'nullable|array',
            'tags.*'           => 'exists:tags,id',
            'status'           => 'required|string|in:draft,published',
            'published_at'     => 'nullable|date',
            'featured_image'   => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        try {
            $post = Post::findOrFail($request->updateId);
            $slug = Str::slug($request->title);

            // Handle featured image upload
            $fileWithLocaton = $post->featured_image;
            if ($request->hasFile('featured_image')) {
                // This will store in storage/app/public/posts/
                $file = $request->file('featured_image');
                $fileLocation = 'uploads/posts/';
                $fileExtention = $file->getClientOriginalExtension();
                $fileName = time() . '.' . $fileExtention;
                $fileWithLocaton = $fileLocation.$fileName;

                // Remove featured image if it exists
                $filePath = public_path($post->featured_image);
                if (file_exists($filePath)) {
                    File::delete($filePath);
                }

                $file->move(public_path($fileLocation), $fileName);
            }

            $post->update([
                'title'            => $validated['title'],
                'slug'             => $slug,
                'excerpt'          => $validated['excerpt'] ?? null,
                'content'          => $validated['content'],
                'blog_category_id' => $validated['blog_category_id'],
                'status'           => $validated['status'],
                'published_at'     => $validated['published_at'] ?? null,
                'featured_image'   => $fileWithLocaton,
            ]);

            // Sync tags and authors (detach+attach in one step)
            if (isset($validated['tags'])) {
                $post->tags()->sync($validated['tags']);
            } else {
                $post->tags()->detach();
            }

            if (isset($validated['authors'])) {
                $post->authors()->sync($validated['authors']);
            } else {
                $post->authors()->detach();
            }

            return response()->json(['status' => 'success', 'message' => 'Post Updated successfully']);
        } catch (\Throwable $th) {
            return response()->json(['status' => 'fail', 'message' => $th->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        try {

            $post = Post::findOrFail($request->id);

            // Remove featured image if it exists
            $filePath = public_path($post->featured_image);
            if (file_exists($filePath)) {
                File::delete($filePath);
            }

            // Detach pivot relations (optional, since cascadeOnDelete is set in migrations)
            $post->tags()->detach();
            $post->authors()->detach();

            $post->delete();

            return response()->json(['status' => 'success', 'message' => 'Post deleted successfully']);
        } catch (\Throwable $th) {
            return response()->json(['status' => 'fail', 'message' => $th->getMessage()]);
        }
    }
}
