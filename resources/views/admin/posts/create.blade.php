<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Kreiraj novi post') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form id="postForm" method="POST" action="{{ route('posts.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-4">
                        <label for="title" class="block text-gray-700 dark:text-gray-300">{{ __('Naslov') }}</label>
                        <input type="text" name="title" id="title" class="w-full border border-gray-300 dark:bg-gray-700 dark:text-gray-100 rounded-md p-2" required>
                    </div>

                    <div class="mb-4">
                        <label for="body" class="block text-gray-700 dark:text-gray-300">{{ __('Sadržaj') }}</label>
                        <!-- Uklonjen je "required" atribut da se izbegne greška, a validacija se može raditi u backend-u -->
                        <textarea name="body" id="body" rows="10" class="w-full border border-gray-300 dark:bg-gray-700 dark:text-gray-100 rounded-md p-2"></textarea>
                    </div>

                    <div class="mb-4">
                        <label for="thumbnail" class="block text-gray-700 dark:text-gray-300">{{ __('Thumbnail') }}</label>
                        <input type="file" name="thumbnail" id="thumbnail" class="w-full border border-gray-300 dark:bg-gray-700 dark:text-gray-100 rounded-md">
                    </div>

                    <div class="mb-4">
                        <label for="meta_title" class="block text-gray-700 dark:text-gray-300">{{ __('Meta Naslov') }}</label>
                        <input type="text" name="meta_title" id="meta_title" class="w-full border border-gray-300 dark:bg-gray-700 dark:text-gray-100 rounded-md p-2">
                    </div>

                    <div class="mb-4">
                        <label for="meta_description" class="block text-gray-700 dark:text-gray-300">{{ __('Meta Opis') }}</label>
                        <input type="text" name="meta_description" id="meta_description" class="w-full border border-gray-300 dark:bg-gray-700 dark:text-gray-100 rounded-md p-2">
                    </div>

                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md">
                        {{ __('Spremi') }}
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Uključi TinyMCE bez API ključa, sa cdnjs -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/6.6.1/tinymce.min.js" referrerpolicy="no-referrer"></script>
    <script>
        tinymce.init({
            selector: '#body',
            base_url: 'https://cdnjs.cloudflare.com/ajax/libs/tinymce/6.6.1',
            skin_url: 'https://cdnjs.cloudflare.com/ajax/libs/tinymce/6.6.1/skins/ui/oxide',
            height: 400,
            plugins: 'advlist autolink lists link image charmap preview anchor searchreplace visualblocks code fullscreen insertdatetime media table paste',
            toolbar: 'undo redo | formatselect | bold italic backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | table | removeformat | code',
            content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:14px }'
        });


        // Pre submit-a, prebacujemo sadržaj iz TinyMCE editor-a u textarea
        document.getElementById('postForm').addEventListener('submit', function(e) {
            tinymce.triggerSave();
        });
    </script>
</x-app-layout>
