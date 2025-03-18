@extends('layouts-front.main')

@section('title', ($post->meta_title ?? $post->title) . ' - Inženjer Tim')
@section('meta_description', $post->meta_description ?? Str::limit(strip_tags($post->body), 150))
@section('meta_keywords', 'blog, inženjering, članci, novosti')

@section('content')
    <!-- Hero Section -->
    <section class="relative bg-gray-900 pt-32 pb-20" id="hero">
        <div class="container mx-auto px-4 max-w-4xl">
            <div class="text-center mb-8">
                <h1 class="text-3xl md:text-4xl font-bold text-white mt-4 leading-tight">
                    {{ $post->title }}
                </h1>
            </div>
            @if($post->thumbnail)
                <div class="rounded-xl overflow-hidden shadow-xl hover:shadow-2xl transition-shadow duration-300">
                    <img
                        src="{{ $post->thumbnail_url }}"
                        alt="{{ $post->title }}"
                        class="w-full h-64 md:h-96 object-cover"
                        loading="lazy"
                    >
                </div>
            @endif
        </div>
    </section>

    <!-- Main Content -->
    <main class="py-12 bg-white">
        <div class="container mx-auto px-4 max-w-7xl">
            <div class="flex flex-col lg:flex-row gap-12">
                <!-- Article Content -->
                <article class="flex-1 max-w-3xl mx-auto">
                    <div class="flex items-center gap-4 text-sm text-gray-500 mb-8">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                            {{ $post->user->name }}
                        </div>
                        <span>•</span>
                        <span class="text-red-500 text-sm font-semibold">{{ $post->published_at?->format('d.m.Y.') ?? 'Draft' }}</span>

                    </div>

                    <div class="prose prose-lg max-w-none text-gray-700">
                        {!! $post->body !!}
                    </div>

                    <!-- Social Sharing -->
                    <div class="mt-12 pt-8 border-t border-gray-200">

                        <div class="flex gap-3">
                            <!-- Add social sharing buttons here -->
                        </div>
                    </div>
                </article>

                <!-- Recommended Posts Sidebar -->
                <aside class="lg:w-80 xl:w-96 space-y-8">
                    <div class="sticky top-24">
                        <h3 class="text-lg font-semibold text-gray-900 mb-6 pb-2 border-b border-gray-200">
                            Preporučeno za vas
                        </h3>

                        <div class="space-y-6">
                            @foreach($randomPosts as $rPost)
                                <a href="{{ route('blog.show', $rPost) }}" class="group block">
                                    <div class="flex gap-4">
                                        @if($rPost->thumbnail)
                                            <div class="flex-shrink-0 w-20 h-20 rounded-lg overflow-hidden">
                                                <img
                                                    src="{{ $rPost->thumbnail_url }}"
                                                    alt="{{ $rPost->title }}"
                                                    class="w-full h-full object-cover transform transition duration-300 group-hover:scale-105"
                                                >
                                            </div>
                                        @endif
                                        <div>
                                            <h4 class="text-base font-medium text-gray-900 group-hover:text-red-600 transition">
                                                {{ $rPost->title }}
                                            </h4>
                                            <p class="text-sm text-gray-500 mt-1">
                                                {{ $rPost->published_at?->format('d.m.Y.') ?? 'N/A' }}
                                            </p>
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                </aside>
            </div>

            <!-- Related Posts -->
            <section class="mt-20 pt-12 border-t border-gray-200">

                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <!-- Add related posts here -->
                </div>
            </section>
        </div>
    </main>
@endsection

@push('styles')
    <style>
        .prose {
            line-height: 1.75;
        }
        .prose img {
            border-radius: 12px;
            margin-top: 2rem;
            margin-bottom: 2rem;
        }
        .prose h2 {
            font-size: 1.5rem;
            font-weight: 700;
            margin-top: 2.5rem;
            margin-bottom: 1rem;
        }
        .prose h3 {
            font-size: 1.25rem;
            font-weight: 600;
            margin-top: 2rem;
            margin-bottom: 1rem;
        }
    </style>
@endpush
