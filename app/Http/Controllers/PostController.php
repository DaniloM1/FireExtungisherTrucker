<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Http\Requests\PostRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::latest()->paginate(10);
        return view('admin.posts.index', compact('posts'));
    }

    public function create()
    {
        return view('admin.posts.create');
    }

    public function store(PostRequest $request)
    {
        $data = $request->only(['title', 'body', 'meta_title', 'meta_description']);
        $data['slug'] = Str::slug($data['title']);

        if ($request->hasFile('thumbnail')) {
            $data['thumbnail'] = $request->file('thumbnail')->store('thumbnails', 'public');
        }

        $data['user_id']      = auth()->id();
        $data['active']       = true;
        $data['published_at'] = now();

        Post::create($data);

        return redirect()->route('posts.index')->with('success', 'Post uspješno kreiran.');
    }

    public function show(Post $post)
    {
        return view('admin.posts.show', compact('post'));
    }

    public function edit(Post $post)
    {
        return view('admin.posts.edit', compact('post'));
    }

    public function update(PostRequest $request, Post $post)
    {
        $data = $request->only(['title', 'body', 'meta_title', 'meta_description']);
        $data['slug'] = Str::slug($data['title']);

        if ($request->hasFile('thumbnail')) {
            if ($post->thumbnail && Storage::disk('public')->exists($post->thumbnail)) {
                Storage::disk('public')->delete($post->thumbnail);
            }
            $data['thumbnail'] = $request->file('thumbnail')->store('thumbnails', 'public');
        }

        $post->update($data);

        return redirect()->route('posts.index')->with('success', 'Post uspješno ažuriran.');
    }

    public function destroy(Post $post)
    {
        if ($post->thumbnail && Storage::disk('public')->exists($post->thumbnail)) {
            Storage::disk('public')->delete($post->thumbnail);
        }

        $post->delete();

        return redirect()->route('posts.index')->with('success', 'Post uspješno obrisan.');
    }
}

