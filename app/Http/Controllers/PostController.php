<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{

    public function index()
    {
        $posts = Post::withDrafts()->get();

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

        return redirect()->route('posts.index');
    }

}