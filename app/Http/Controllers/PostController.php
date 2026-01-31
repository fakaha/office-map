<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {
        $post = Post::select('id', 'id', 'user_id', 'title', 'content', 'created_at', 'updated_at')->paginate(20);

        return response()->json([
            'posts' => $post,
        ]);
    }

    public function create()
    {
        return view('posts.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        $post = Post::create([
            'title' => $validated['title'],
            'content' => $validated['content'],
            'user_id' => $request->user()->id,
        ]);

        return response()->json([
            'post' => $post,
        ]);
    }

    public function show($id)
    {
        $post = Post::findOrFail($id);

        if ($post->is_draft == 1) {
            abort(404);
        }

        return response()->json([
            'post' => $post,
        ]);
    }

    public function edit(Post $post)
    {
        $this->authorize('update', $post);

        $data['post'] = $post;

        return view('posts.edit', $data);
    }

    public function update(Request $request, Post $post)
    {
        $this->authorize('update', $post);
        $validated = $request->validate([
            'title' => 'nullable|string',
            'content' => 'nullable|string',
        ]);

        $post->update($validated);

        return response()->json([
            'post' => $post,
            'message' => 'Post updated successfully',
        ]);
    }

    public function destroy(Post $post)
    {
        $this->authorize('delete', $post);

        $post->delete();

        return response()->json([
            'message' => 'Post deleted successfully',
        ]);
    }
}
