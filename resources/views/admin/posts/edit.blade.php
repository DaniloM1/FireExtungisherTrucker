<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Uredi post') }}
            </h2>

        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form method="POST" action="{{ route('posts.update', $post) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label for="title" class="block text-gray-700 dark:text-gray-300">{{ __('Naslov') }}</label>
                        <input type="text" name="title" id="title" value="{{ $post->title }}" class="w-full border-gray-300 dark:bg-gray-700 dark:text-gray-100 rounded-md" required>
                    </div>

                    <div class="mb-4">
                        <label for="body" class="block text-gray-700 dark:text-gray-300">{{ __('Sadržaj') }}</label>
                        <textarea name="body" id="body" rows="6" class="w-full border-gray-300 dark:bg-gray-700 dark:text-gray-100 rounded-md" required>{{ $post->body }}</textarea>
                    </div>

                    <div class="mb-4">
                        <label for="thumbnail" class="block text-gray-700 dark:text-gray-300">{{ __('Thumbnail') }}</label>
                        @if($post->thumbnail)
                            <div class="mb-2">
                                <img src="{{ $post->thumbnail_url }}" alt="{{ $post->title }}" class="w-32 h-auto rounded">
                            </div>
                        @endif
                        <input type="file" name="thumbnail" id="thumbnail" class="w-full border-gray-300 dark:bg-gray-700 dark:text-gray-100 rounded-md">
                    </div>

                    <div class="mb-4">
                        <label for="meta_title" class="block text-gray-700 dark:text-gray-300">{{ __('Meta Naslov') }}</label>
                        <input type="text" name="meta_title" id="meta_title" value="{{ $post->meta_title }}" class="w-full border-gray-300 dark:bg-gray-700 dark:text-gray-100 rounded-md">
                    </div>

                    <div class="mb-4">
                        <label for="meta_description" class="block text-gray-700 dark:text-gray-300">{{ __('Meta Opis') }}</label>
                        <input type="text" name="meta_description" id="meta_description" value="{{ $post->meta_description }}" class="w-full border-gray-300 dark:bg-gray-700 dark:text-gray-100 rounded-md">
                    </div>

                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">
                        {{ __('Spremi izmjene') }}
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script>
        const themeToggle = document.getElementById('theme-toggle');
        themeToggle.addEventListener('click', () => {
            document.documentElement.classList.toggle('dark');
        });
    </script>
</x-app-layout>
