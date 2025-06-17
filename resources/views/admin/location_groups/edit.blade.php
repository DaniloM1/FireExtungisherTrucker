<x-app-layout>
    <x-slot name="header">
            <h3 class="text-2xl font-bold text-gray-800 dark:text-gray-200 mb-2">
                Izmena grupe lokacija
            </h3>
    </x-slot>

    <div class="max-w-3xl mx-auto mt-8">
        <!-- Greške -->
        @if ($errors->any())
            <div class="bg-red-600 text-white p-4 rounded mb-4 shadow">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="bg-white dark:bg-gray-800 shadow sm:rounded-lg p-8">
            <form action="{{ route('location-groups.update', $locationGroup->id) }}" method="POST" autocomplete="off">
                @csrf
                @method('PUT')

                <div class="mb-6">
                    <label for="name" class="block text-gray-700 dark:text-gray-200 font-bold mb-2">
                        Naziv grupe
                    </label>
                    <input type="text" name="name" id="name" value="{{ old('name', $locationGroup->name) }}" required
                           class="rounded-lg border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200 w-full px-3 py-2 focus:ring-2 focus:ring-blue-400 transition" />
                </div>

                <div class="mb-6">
                    <label for="description" class="block text-gray-700 dark:text-gray-200 font-bold mb-2">
                        Opis (opciono)
                    </label>
                    <textarea name="description" id="description" rows="3"
                              class="rounded-lg border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200 w-full px-3 py-2 focus:ring-2 focus:ring-blue-400 transition">{{ old('description', $locationGroup->description) }}</textarea>
                </div>

                <div class="mb-6">
                    <label class="block text-gray-700 dark:text-gray-200 font-bold mb-2">
                        Izaberi lokacije
                    </label>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 max-h-64 overflow-y-auto bg-gray-50 dark:bg-gray-700 p-3 rounded">
                        @foreach ($locations as $location)
                            <label class="flex items-center space-x-2 cursor-pointer text-gray-700 dark:text-gray-200">
                                <input
                                    type="checkbox"
                                    name="locations[]"
                                    value="{{ $location->id }}"
                                    class="form-checkbox h-5 w-5 text-blue-600 rounded"
                                    {{ in_array($location->id, $locationGroup->locations->pluck('id')->toArray()) ? 'checked' : '' }}
                                >
                                <span>{{ $location->name }} <span class="text-xs text-gray-400 dark:text-gray-400">{{ $location->city }}</span></span>
                            </label>
                        @endforeach
                    </div>
                </div>

                <div class="flex justify-between items-center mt-8">
                    <a href="{{ route('location-groups.index') }}"
                       class="inline-block font-semibold px-4 py-2 rounded-md bg-gray-300 dark:bg-gray-600 text-gray-800 dark:text-gray-200 hover:bg-gray-400 dark:hover:bg-gray-500 transition">
                        &#8592; Nazad
                    </a>
                    <button type="submit"
                            class="bg-blue-600 hover:bg-blue-700 text-white font-bold px-6 py-2 rounded-lg shadow transition">
                        Sačuvaj promene
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>

