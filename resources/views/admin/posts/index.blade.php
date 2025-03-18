<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-gray-800 dark:text-gray-200">
            {{ __('Blog') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow overflow-hidden sm:rounded-lg p-6">
                <div class="mb-6 flex justify-between items-center">
                    <a href="{{ route('posts.create') }}" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-md transition duration-200">
                        {{ __('Dodaj novi post') }}
                    </a>
                    <!-- Ovdje možeš dodati eventualni search ili filter -->
                    <div>
                        <input type="text" placeholder="{{ __('Pretraži postove...') }}" class="px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-gray-50 dark:bg-gray-700 text-gray-800 dark:text-gray-200 focus:outline-none focus:ring focus:border-blue-300">
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                {{ __('Naslov') }}
                            </th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                {{ __('Akcije') }}
                            </th>
                        </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-900 divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach($posts as $post)
                            <tr class="hover:bg-gray-100 dark:hover:bg-gray-800 transition duration-150">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-100">
                                    {{ $post->title }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-center">
                                    <!-- Koristi jednu boju ikona, koja se prilagođava temi -->
                                    <a href="{{ route('posts.edit', $post) }}" class="inline-block mx-1 text-gray-600 dark:text-gray-300 hover:text-gray-800 dark:hover:text-gray-100 transition duration-150">
                                        <i class="fas fa-edit"></i>
                                        <span class="sr-only">{{ __('Uredi') }}</span>
                                    </a>
                                    <a href="{{ route('posts.show', $post) }}" class="inline-block mx-1 text-gray-600 dark:text-gray-300 hover:text-gray-800 dark:hover:text-gray-100 transition duration-150">
                                        <i class="fas fa-eye"></i>
                                        <span class="sr-only">{{ __('Prikaži') }}</span>
                                    </a>
                                    <form action="{{ route('posts.destroy', $post) }}" method="POST" class="inline-block mx-1" onsubmit="return confirm('{{ __('Da li ste sigurni?') }}');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-gray-600 dark:text-gray-300 hover:text-gray-800 dark:hover:text-gray-100 transition duration-150">
                                            <i class="fas fa-trash-alt"></i>
                                            <span class="sr-only">{{ __('Obriši') }}</span>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination, ako je primjenjivo -->
                <div class="mt-6">
                    {{ $posts->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
