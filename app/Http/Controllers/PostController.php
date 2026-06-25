<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PostController extends Controller
{
    private function normalizeStatus($value)
    {
        if ($value === 'publish') return 'published';
        if ($value === 'draft') return 'draft';
        if ($value === 'review') return 'review';
        return $value;
    }

    public function index(Request $request)
    {
        return view('posts.index');
    }

    public function create()
    {
        return view('posts.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'   => 'required|min:3|max:255',
            'content' => 'nullable|string',
        ]);

        $status = $this->normalizeStatus($request->status ?? 'draft');

        $post = Post::create([
            'title'          => $request->title,
            'content'        => $request->content,
            'status'         => $status,
            'is_published'   => $status === 'published',
            'publisher_type' => \App\Models\User::class,
            'publisher_id'   => auth()->id() ?? 1,
        ]);

        DB::table('post_versions')->insert([
            'post_id'    => $post->id,
            'title'      => $post->title,
            'content'    => $post->content,
            'version'    => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('posts.index')
            ->with('success', 'Post created successfully.');
    }

    public function preview($id)
    {
        $post = Post::withoutGlobalScopes()->findOrFail($id);
        return view('posts.preview', compact('post'));
    }

    public function edit($id)
    {
        $post     = Post::withoutGlobalScopes()->findOrFail($id);
        $versions = DB::table('post_versions')
            ->where('post_id', $id)
            ->orderBy('version', 'desc')
            ->get();

        return view('posts.edit', compact('post', 'versions'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title'   => 'required|min:3|max:255',
            'content' => 'nullable|string',
        ]);

        $post = Post::withoutGlobalScopes()->findOrFail($id);

        $status = $this->normalizeStatus($request->status ?? $post->status);

        $post->title          = $request->title;
        $post->content        = $request->content;
        $post->status         = $status;
        $post->is_published   = $status === 'published';
        $post->publisher_type = \App\Models\User::class;
        $post->publisher_id   = auth()->id() ?? 1;
        
        if ($status === 'published') {
            $post->published_at = now();
        }

        $post->save();

        $latestVersion = DB::table('post_versions')
            ->where('post_id', $id)
            ->max('version') ?? 0;

        DB::table('post_versions')->insert([
            'post_id'    => $post->id,
            'title'      => $post->title,
            'content'    => $post->content,
            'version'    => $latestVersion + 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('posts.index')
            ->with('success', 'Post updated successfully.');
    }

    public function destroy($id)
    {
        $post = Post::withoutGlobalScopes()->findOrFail($id);
        $post->delete();

        return redirect()->route('posts.index')
            ->with('success', 'Post deleted successfully.');
    }

    public function liveSearch(Request $request)
    {
        $search = $request->search;
        $status = $request->status;

        $query = Post::withoutGlobalScopes();

        if ($search) {
            $query->where('title', 'LIKE', '%' . $search . '%');
        }

        if ($status) {
            $query->where('status', $status);
        }

        $posts = $query->orderBy('id', 'desc')->paginate(10);

        if ($request->ajax() || $request->has('ajax')) {
            return view('posts.partials.posts-table', compact('posts'))->render();
        }

        return view('posts.index', compact('posts'));
    }

    public function autoSave(Request $request, $id)
    {
        $post = Post::withoutGlobalScopes()->findOrFail($id);

        $post->title   = $request->title ?? $post->title;
        $post->content = $request->content ?? $post->content;
        $post->save();

        return response()->json([
            'success' => true,
            'message' => 'Auto-save successful',
        ]);
    }

    public function restoreVersion($id, $versionId)
    {
        $post    = Post::withoutGlobalScopes()->findOrFail($id);
        $version = DB::table('post_versions')->where('id', $versionId)->first();

        if ($version) {
            $post->title   = $version->title;
            $post->content = $version->content;
            $post->save();
        }

        return redirect()->back()->with('success', 'Version restored successfully.');
    }

    public function collaborate(Request $request, $id)
    {
        $post = Post::withoutGlobalScopes()->findOrFail($id);

        $post->content = $request->content;
        $post->save();

        return response()->json([
            'success' => true,
            'content' => $post->content,
        ]);
    }
}