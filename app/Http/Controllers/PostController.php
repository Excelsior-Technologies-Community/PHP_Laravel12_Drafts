<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{

    public function index(Request $request)
    {
        $query = Post::withDrafts();

        // SEARCH
        if ($request->search) {
            $query->where('title', 'LIKE', '%' . $request->search . '%');
        }

        // FILTER
        if ($request->status == 'draft') {
            $query->where('is_published', false);
        }

        if ($request->status == 'published') {
            $query->where('is_published', true);
        }

        // PAGINATION (10 posts per page)
        $posts = $query->orderBy('id', 'desc')->paginate(10);

        return view('posts.index', compact('posts'));
    }

    public function create()
    {
        return view('posts.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|min:3|max:255',
            'content' => 'nullable|string'
        ]);

        if ($request->status == "draft") {
            Post::createDraft([
                'title' => $request->title,
                'content' => $request->content
            ]);
        } else {
            Post::create([
                'title' => $request->title,
                'content' => $request->content
            ]);
        }

        return redirect()->route('posts.index')
            ->with('success', 'Post created successfully.');
    }

    // PREVIEW FEATURE
    public function preview($id)
    {
        $post = Post::withDrafts()->findOrFail($id);
        return view('posts.preview', compact('post'));
    }

    // EDIT FEATURE
    public function edit($id)
    {
        $post = Post::withDrafts()->findOrFail($id);
        return view('posts.edit', compact('post'));
    }

    // UPDATE FEATURE
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|min:3|max:255',
            'content' => 'nullable|string'
        ]);

        $post = Post::withDrafts()->findOrFail($id);

        $post->title = $request->title;
        $post->content = $request->content;

        if ($request->has('status')) {
            $post->is_published = ($request->status == 'publish');
        }

        $post->save();

        return redirect()->route('posts.index')
            ->with('success', 'Post updated successfully.');
    }

    // DELETE FEATURE
    public function destroy($id)
    {
        $post = Post::withDrafts()->findOrFail($id);
        $post->delete();

        return redirect()->route('posts.index')
            ->with('success', 'Post deleted successfully.');
    }

    // LIVE SEARCH (AJAX)
   // LIVE SEARCH (AJAX)
public function liveSearch(Request $request)
{
    $search = $request->search;
    $status = $request->status;

    $query = Post::withDrafts();

    if ($search) {
        $query->where('title', 'LIKE', '%' . $search . '%');
    }

    if ($status == 'draft') {
        $query->where('is_published', false);
    } elseif ($status == 'published') {
        $query->where('is_published', true);
    }

    $posts = $query->orderBy('id', 'desc')->paginate(10);

    // Return only the partial view for AJAX requests
    if ($request->ajax() || $request->has('ajax')) {
        return view('posts.partials.posts-table', compact('posts'))->render();
    }

    // For normal requests, return full view
    return view('posts.index', compact('posts'));
}
}