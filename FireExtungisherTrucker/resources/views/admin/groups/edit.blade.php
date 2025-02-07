<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Group') }}
        </h2>
    </x-slot>

    <!-- Prikaz grešaka validacije -->
    <div class="max-w-7xl mx-auto mt-4">
        @if ($errors->any())
            <div class="bg-red-500 text-white p-4 rounded mb-4">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>

    <!-- Forma za uređivanje grupe -->
    <div class="max-w-7xl mx-auto">
        <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
            <form action="{{ route('groups.update', $group->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label for="name" class="block text-gray-700 dark:text-gray-300 font-bold mb-2">
                        {{ __('Group Name') }}
                    </label>
                    <input type="text" name="name" id="name" value="{{ old('name', $group->name) }}" required
                           class="w-full border-gray-300 dark:border-gray-600 rounded p-2 dark:bg-gray-700 dark:text-white">
                </div>

                <div class="mb-4">
                    <label for="description" class="block text-gray-700 dark:text-gray-300 font-bold mb-2">
                        {{ __('Description') }}
                    </label>
                    <textarea name="description" id="description" rows="3"
                              class="w-full border-gray-300 dark:border-gray-600 rounded p-2 dark:bg-gray-700 dark:text-white">{{ old('description', $group->description) }}</textarea>
                </div>

                <div class="mb-4">
                    <label for="next_service_date" class="block text-gray-700 dark:text-gray-300 font-bold mb-2">
                        {{ __('Next Service Date') }}
                    </label>
                    <input type="date" name="next_service_date" id="next_service_date"
                           value="{{ old('next_service_date', $group->next_service_date ? \Carbon\Carbon::parse($group->next_service_date)->format('Y-m-d') : '') }}"
                           class="w-full border-gray-300 dark:border-gray-600 rounded p-2 dark:bg-gray-700 dark:text-white">
                </div>

                <div class="flex justify-end">
                    <a href="{{ route('locations.groups.index', $group->location_id) }}"
                       class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded mr-2">
                        {{ __('Cancel') }}
                    </a>
                    <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">
                        {{ __('Update Group') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
