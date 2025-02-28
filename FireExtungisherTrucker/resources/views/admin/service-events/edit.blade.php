<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Service Event') }}
        </h2>
    </x-slot>

    <div class="py-6 bg-gray-100 dark:bg-gray-900">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow sm:rounded-lg p-6">
                <form method="POST" action="{{ route('service-events.update', $serviceEvent->id) }}">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 gap-4">
                        <!-- Category -->
                        <div>
                            <label for="category" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Category
                            </label>
                            <select name="category" id="category" required
                                    class="mt-1 block w-full rounded-md border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200 focus:border-blue-500 focus:ring-blue-500">
                                <option value="pp_device" {{ $serviceEvent->category == 'pp_device' ? 'selected' : '' }}>PP Device</option>
                                <option value="hydrant" {{ $serviceEvent->category == 'hydrant' ? 'selected' : '' }}>Hydrant</option>
                            </select>
                        </div>

                        <!-- Service Date -->
                        <div>
                            <label for="service_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Service Date
                            </label>
                            <input type="date" name="service_date" id="service_date"
                                   value="{{ $serviceEvent->service_date->format('Y-m-d') }}"
                                   required
                                   class="mt-1 block w-full rounded-md border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200 focus:border-blue-500 focus:ring-blue-500">
                        </div>

                        <!-- Next Service Date -->
                        <div>
                            <label for="next_service_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Next Service Date
                            </label>
                            <input type="date" name="next_service_date" id="next_service_date"
                                   value="{{ $serviceEvent->next_service_date->format('Y-m-d') }}"
                                   required
                                   class="mt-1 block w-full rounded-md border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200 focus:border-blue-500 focus:ring-blue-500">
                        </div>

                        <!-- Evid Number -->
                        <div>
                            <label for="evid_number" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Evid Number
                            </label>
                            <input type="text" name="evid_number" id="evid_number"
                                   value="{{ $serviceEvent->evid_number }}"
                                   required
                                   class="mt-1 block w-full rounded-md border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200 focus:border-blue-500 focus:ring-blue-500">
                        </div>

                        <!-- User ID -->
                        <div>
                            <label for="user_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                User ID
                            </label>
                            <input type="number" name="user_id" id="user_id"
                                   value="{{ $serviceEvent->user_id }}"
                                   required
                                   class="mt-1 block w-full rounded-md border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200 focus:border-blue-500 focus:ring-blue-500">
                        </div>

                        <!-- Description -->
                        <div>
                            <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Description
                            </label>
                            <textarea name="description" id="description" rows="3"
                                      class="mt-1 block w-full rounded-md border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200 focus:border-blue-500 focus:ring-blue-500">{{ $serviceEvent->description }}</textarea>
                        </div>

                        <!-- Cost -->
                        <div>
                            <label for="cost" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Cost
                            </label>
                            <input type="number" step="0.01" name="cost" id="cost"
                                   value="{{ $serviceEvent->cost }}"
                                   required
                                   class="mt-1 block w-full rounded-md border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200 focus:border-blue-500 focus:ring-blue-500">
                        </div>

                        <!-- Locations -->
                        <div>
                            <label for="locations" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Select Locations
                            </label>
                            <select name="locations[]" id="locations" multiple required
                                    class="mt-1 block w-full rounded-md border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200 focus:border-blue-500 focus:ring-blue-500">
                                @foreach($locations as $location)
                                    <option value="{{ $location->id }}"
                                        {{ $serviceEvent->locations->pluck('id')->contains($location->id) ? 'selected' : '' }}>
                                        {{ $location->name }} - {{ $location->city }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="mt-6 flex justify-end space-x-4">
                        <a href="{{ route('service-events.index') }}"
                           class="px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white rounded">
                            Cancel
                        </a>
                        <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded">
                            Update Service Event
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
