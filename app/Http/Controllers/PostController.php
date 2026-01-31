<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::with('user')
            ->where('is_draft', false)
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now())
            ->paginate(20);

        return response()->json([
            'posts' => $posts,
        ]);
    }

    public function create()
    {
        return 'posts.create';
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

        if ($post->is_draft || $post->published_at > now()) {
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

        return 'posts.edit';
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
