<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Service Events') }}
        </h2>
    </x-slot>

    <div class="py-6 bg-gray-100 dark:bg-gray-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Success Message -->
            @if(session('success'))
                <div class="bg-green-600 text-white p-4 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Create New Service Event Button -->
            <div class="flex justify-end mb-6">
                <a href="{{ route('service-events.create') }}"
                class= "hover:underline">
                <i class="fas fa-plus"></i> {{ __('Create New Servis') }}
            </div>

            <!-- Group by Company -->
            @foreach($companies as $company)
                <div class="mb-8 border border-gray-200 dark:border-gray-700 rounded-lg p-4 bg-white dark:bg-gray-800 shadow">
                    <!-- Company Header -->
                    <div class="mb-4">
                        <h3 class="text-2xl font-bold text-gray-800 dark:text-gray-200">
                            {{ $company->name }}
                            <span class="text-base text-gray-600 dark:text-gray-400">({{ $company->city }})</span>
                        </h3>
                    </div>

                    <!-- Locations for this Company -->
                    @if($company->locations->isNotEmpty())
                        @foreach($company->locations as $location)
                            <div class="mb-6 border-t border-gray-200 dark:border-gray-700 pt-4">
                                <h4 class="text-xl font-semibold text-gray-700 dark:text-gray-300">
                                    {{ $location->name }} - {{ $location->city }}
                                </h4>

                                <!-- Desktop View: Table of Service Events -->
                                <div class="hidden md:block mt-2 overflow-x-auto">
                                    @if($location->serviceEvents->isNotEmpty())
                                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                            <thead class="bg-gray-50 dark:bg-gray-700">
                                            <tr>
                                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">ID</th>
                                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Category</th>
                                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Service Date</th>
                                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Next Service Date</th>
                                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Evid Number</th>
                                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Cost</th>
                                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Actions</th>
                                            </tr>
                                            </thead>
                                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                            @foreach($location->serviceEvents as $event)
                                                <tr>
                                                    <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">{{ $event->id }}</td>
                                                    <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">{{ ucfirst($event->category) }}</td>
                                                    <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">{{ $event->service_date->format('Y-m-d') }}</td>
                                                    <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">{{ $event->next_service_date->format('Y-m-d') }}</td>
                                                    <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">{{ $event->evid_number }}</td>
                                                    <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">{{ $event->cost }}</td>
                                                    <td class="px-4 py-2 whitespace-nowrap text-sm">
                                                        <div class="flex space-x-2">
                                                            <a href="{{ route('service-events.edit', $event->id) }}" class="text-blue-600 dark:text-blue-400 hover:underline">Edit</a>
                                                            <form action="{{ route('service-events.destroy', $event->id) }}" method="POST" onsubmit="return confirm('Are you sure?')" class="inline">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="text-red-600 dark:text-red-400 hover:underline">Delete</button>
                                                            </form>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    @else
                                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-2">No service events for this location.</p>
                                    @endif
                                </div>

                                <!-- Mobile View: Card Layout -->
                                <div class="md:hidden mt-2 space-y-4">
                                    @if($location->serviceEvents->isNotEmpty())
                                        @foreach($location->serviceEvents as $event)
                                            <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-4">
                                                <div class="flex justify-between items-center">
                                                    <h4 class="text-lg font-semibold text-gray-900 dark:text-gray-200">Event #{{ $event->id }}</h4>
                                                    <div class="flex space-x-2">
                                                        <a href="{{ route('service-events.edit', $event->id) }}" class="text-blue-600 dark:text-blue-400 hover:underline">Edit</a>
                                                        <form action="{{ route('service-events.destroy', $event->id) }}" method="POST" onsubmit="return confirm('Are you sure?')">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="text-red-600 dark:text-red-400 hover:underline">Delete</button>
                                                        </form>
                                                    </div>
                                                </div>
                                                <div class="mt-2 space-y-1">
                                                    <p class="text-sm text-gray-700 dark:text-gray-300"><strong>Category:</strong> {{ ucfirst($event->category) }}</p>
                                                    <p class="text-sm text-gray-700 dark:text-gray-300"><strong>Service Date:</strong> {{ $event->service_date->format('Y-m-d') }}</p>
                                                    <p class="text-sm text-gray-700 dark:text-gray-300"><strong>Next Service Date:</strong> {{ $event->next_service_date->format('Y-m-d') }}</p>
                                                    <p class="text-sm text-gray-700 dark:text-gray-300"><strong>Evid Number:</strong> {{ $event->evid_number }}</p>
                                                    <p class="text-sm text-gray-700 dark:text-gray-300"><strong>Cost:</strong> {{ $event->cost }}</p>
                                                </div>
                                            </div>
                                        @endforeach
                                    @else
                                        <p class="text-sm text-gray-500 dark:text-gray-400">No service events for this location.</p>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    @else
                        <p class="text-sm text-gray-500 dark:text-gray-400">No locations found for this company.</p>
                    @endif
                </div>
            @endforeach
        </div>
    </div>
</x-app-layout>
