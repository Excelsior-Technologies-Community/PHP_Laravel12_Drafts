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

        $posts = $query->orderBy('id', 'asc')->get();

        return view('posts.index', compact('posts'));
    }

    public function create()
    {
        return view('posts.create');
    }

    public function store(Request $request)
    {

        $request->validate([
            'title' => 'required'
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
}