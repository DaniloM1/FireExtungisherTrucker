<?php
namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PostController extends Controller
{
    // Prikaz svih postova
    public function index()
    {
        $posts = Post::latest()->paginate(10);
        return view('admin.posts.index', compact('posts'));
    }

    // Prikaz forme za kreiranje novog posta
    public function create()
    {
        return view('admin.posts.create');
    }

    // Spremanje novog posta
    public function store(Request $request)
    {
//        dd($request);
        $request->validate([
            'title'            => 'required|string|max:2048',
            'body'             => 'required',
            'thumbnail'        => 'nullable|image|max:2048',
            'meta_title'       => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:255',
        ]);

        $data = $request->only(['title', 'body', 'meta_title', 'meta_description']);
        $data['slug'] = Str::slug($data['title']);

        if ($request->hasFile('thumbnail')) {
            $data['thumbnail'] = $request->file('thumbnail')->store('thumbnails', 'public');
        }

        $data['user_id'] = auth()->id();
        $data['active']  = true;
        $data['published_at'] = now();

        Post::create($data);

        return redirect()->route('posts.index')->with('success', 'Post uspješno kreiran.');
    }

    // Prikaz pojedinačnog posta
    public function show(Post $post)
    {
        return view('admin.posts.show', compact('post'));
    }

    // Prikaz forme za uređivanje posta
    public function edit(Post $post)
    {
        return view('admin.posts.edit', compact('post'));
    }

    // Ažuriranje posta
    public function update(Request $request, Post $post)
    {
        $request->validate([
            'title'            => 'required|string|max:2048',
            'body'             => 'required',
            'thumbnail'        => 'nullable|image|max:2048',
            'meta_title'       => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:255',
        ]);

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

    // Brisanje posta
    public function destroy(Post $post)
    {
        if ($post->thumbnail && Storage::disk('public')->exists($post->thumbnail)) {
            Storage::disk('public')->delete($post->thumbnail);
        }

        $post->delete();

        return redirect()->route('posts.index')->with('success', 'Post uspješno obrisan.');
    }
}

