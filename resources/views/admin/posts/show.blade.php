<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Prikaz posta') }}
            </h2>

        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100 mb-4">{{ $post->title }}</h1>
                @if($post->thumbnail)
                    <div class="mb-4">
                        <img src="{{ $post->thumbnail_url }}" alt="{{ $post->title }}" loading="lazy">

                    </div>
                @endif
                <div class="text-gray-700 dark:text-gray-300">
                    {!! nl2br(e($post->body)) !!}
                </div>
                @if($post->meta_title || $post->meta_description)
                    <div class="mt-6 border-t pt-4 text-sm text-gray-500 dark:text-gray-400">
                        <p><strong>{{ __('Meta Naslov:') }}</strong> {{ $post->meta_title }}</p>
                        <p><strong>{{ __('Meta Opis:') }}</strong> {{ $post->meta_description }}</p>
                    </div>
                @endif
            </div>
        </div>
    </div>


</x-app-layout>
