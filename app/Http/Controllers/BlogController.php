<?php

namespace App\Http\Controllers;

use App\Models\Post;

class BlogController extends Controller
{
    public function index()
    {
        $posts = Post::with('user')
            ->where('active', true)
            ->latest()
            ->paginate(10);

        return view('front.blog.index', compact('posts'));
    }

    public function show(Post $post)
    {
        $randomPosts = Post::where('id', '!=', $post->id)
            ->inRandomOrder()
            ->take(3)
            ->get();

        return view('front.blog.show', compact('post', 'randomPosts'));
    }
}
