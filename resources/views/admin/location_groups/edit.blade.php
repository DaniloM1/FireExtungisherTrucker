<x-app-layout>
    <x-slot name="header">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 mb-6">
            <h3 class="text-2xl font-bold text-gray-800 dark:text-gray-200 mb-2">
                Create Location Group
            </h3>
        </div>
        <div class="mt-4">
            <nav class="text-sm text-gray-500">
                Dashboard <span class="mx-2">&rarr;</span> Location Groups <span class="mx-2">&rarr;</span> Create Location Group
            </nav>
        </div>
    </x-slot>

    <!-- Prikaz grešaka -->
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

    <div class="py-12">
        <div class="max-w-7xl mx-auto">
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
                <form action="{{ route('location-groups.store') }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label for="name" class="block text-gray-700 dark:text-gray-300 font-bold mb-2">Group Name</label>
                        <input type="text" name="name" id="name" value="{{ old('name') }}" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Enter group name">
                    </div>
                    <div class="mb-4">
                        <label for="description" class="block text-gray-700 dark:text-gray-300 font-bold mb-2">Description</label>
                        <textarea name="description" id="description" rows="4" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Enter description (optional)">{{ old('description') }}</textarea>
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 dark:text-gray-300 font-bold mb-2">Select Locations</label>
                        <div class="grid grid-cols-2 gap-4">
                            @foreach ($locations as $location)
                                <div>
                                    <input type="checkbox" name="locations[]" id="location_{{ $location->id }}" value="{{ $location->id }}">
                                    <label for="location_{{ $location->id }}">{{ $location->name }}</label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="flex items-center justify-between">
                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                            Create Group
                        </button>
                        <a href="{{ route('location-groups.index') }}" class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800">
                            Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
