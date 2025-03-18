@extends('layouts-front.main')

@section('title', 'Blog - Inženjer Tim')
@section('meta_description', 'Poslednje novosti, saveti i članci iz sveta inženjeringa. Otkrijte najnovije trendove i korisne informacije.')
@section('meta_keywords', 'blog, inženjering, novosti, saveti, članci')

@section('content')
    <!-- Hero Sekcija -->
    <section id="hero" class="relative h-[40vh] flex items-center overflow-hidden bg-gray-900">
        <div class="absolute inset-0 bg-black opacity-60"></div>
        <div class="container mx-auto px-4 text-center relative z-10">
            <h1 class="text-4xl md:text-6xl font-extrabold text-white mb-4">Blog</h1>
            <p class="text-xl text-gray-300">Poslednje novosti i saveti iz sveta inženjeringa.</p>
        </div>
    </section>

    <!-- Lista Blog Postova -->
    <section id="blog-posts" class="py-10 bg-white">
        <div class="container mx-auto px-4 max-w-7xl">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                @forelse($posts as $post)
                    <div class="bg-white shadow rounded overflow-hidden flex flex-col">
                        @if($post->thumbnail)
                            <div class="h-48 overflow-hidden">
                                <img src="{{ $post->thumbnail_url }}" alt="{{ $post->title }}" class="w-full h-full object-cover transition-transform duration-300 hover:scale-105" loading="lazy">
                            </div>
                        @endif
                        <div class="p-4 flex flex-col flex-grow">
                            <h2 class="text-xl font-bold text-gray-800 mb-2">
                                <a href="{{ route('blog.show', $post) }}" class="hover:text-red-600 transition-colors duration-200">
                                    {{ $post->title }}
                                </a>
                            </h2>
                            <p class="text-gray-600 text-sm mb-4">
                                {{ $post->meta_description ? $post->meta_description : Str::limit(strip_tags($post->body), 80) }}
                            </p>
                            <div class="flex items-center justify-between mt-auto">
                                <div class="text-gray-500 text-xs">
                                    <span>Autor: {{ $post->user->name }}</span><br>
                                    <span>Objavljeno: {{ $post->published_at ? $post->published_at->format('d.m.Y.') : '-' }}</span>
                                </div>
                                <a href="{{ route('blog.show', $post) }}" class="inline-block text-white bg-red-600 hover:bg-red-700 px-3 py-1 rounded transition-colors duration-200 text-sm">
                                    Pročitaj više
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center text-gray-600">Nema postova.</div>
                @endforelse
            </div>

            <!-- Pagination -->
            <div class="mt-8">
                {{ $posts->links() }}
            </div>
        </div>
    </section>
@endsection
