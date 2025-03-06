<x-app-layout>
    <!-- Header -->
    <x-slot name="header">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 mb-6">
            <h3 class="text-2xl font-bold text-gray-800 dark:text-gray-200 mb-2">
                Service Event #{{ $serviceEvent->id }} - {{ ucfirst($serviceEvent->category) }}
            </h3>
            <p class="text-gray-600 dark:text-gray-400">
                Evid Number: {{ $serviceEvent->evid_number }}
            </p>
        </div>
        <div class="mt-4">
            <nav class="text-sm text-gray-500">
                Service Events <span class="mx-2">&rarr;</span> Details
            </nav>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Service Event Basic Details -->
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6 mb-8">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <h4 class="text-lg font-semibold text-gray-800 dark:text-gray-200">Service Date</h4>
                        <p class="text-gray-700 dark:text-gray-300">{{ \Carbon\Carbon::parse($serviceEvent->service_date)->format('d.m.Y') }}</p>
                    </div>
                    <div>
                        <h4 class="text-lg font-semibold text-gray-800 dark:text-gray-200">Next Service Date</h4>
                        <p class="text-gray-700 dark:text-gray-300">{{ \Carbon\Carbon::parse($serviceEvent->next_service_date)->format('d.m.Y') }}</p>
                    </div>
                    <div>
                        <h4 class="text-lg font-semibold text-gray-800 dark:text-gray-200">Cost</h4>
                        <p class="text-gray-700 dark:text-gray-300">{{ number_format($serviceEvent->cost, 2) }} RSD</p>
                    </div>
                    <div>
                        <h4 class="text-lg font-semibold text-gray-800 dark:text-gray-200">User ID</h4>
                        <p class="text-gray-700 dark:text-gray-300">{{ $serviceEvent->user_id }}</p>
                    </div>
                </div>
                @if($serviceEvent->description)
                    <div class="mt-6">
                        <h4 class="text-lg font-semibold text-gray-800 dark:text-gray-200">Description</h4>
                        <p class="text-gray-700 dark:text-gray-300">{{ $serviceEvent->description }}</p>
                    </div>
                @endif
            </div>

            <!-- Associated Locations Desktop View -->
            <div class="mt-8 hidden md:block">
                <h4 class="text-xl font-bold text-gray-800 dark:text-gray-200 mb-4">Associated Locations</h4>
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Name</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Address</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">City</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Next Service Date</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                @if($serviceEvent->category == 'pp_device')
                                    Devices
                                @elseif($serviceEvent->category == 'hydrant')
                                    Hydrants
                                @endif
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Company</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse($serviceEvent->locations as $location)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $location->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $location->address }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $location->city }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($location->serviceEvents->isNotEmpty())
                                        {{ \Carbon\Carbon::parse($location->serviceEvents->first()->next_service_date)->format('d.m.Y') }}
                                    @else
                                        N/A
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($serviceEvent->category == 'pp_device')
                                        {{ $location->devices->count() ?? 0 }}
                                    @elseif($serviceEvent->category == 'hydrant')
                                        {{ $location->hydrants->count() ?? 0 }}
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($location->company)
                                        {{ $location->company->name }}
                                    @else
                                        N/A
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-4 text-center text-gray-500 dark:text-gray-300">No locations found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Associated Locations Mobile View -->
            <div class="mt-8 md:hidden">
                <h4 class="text-xl font-bold text-gray-800 dark:text-gray-200 mb-4">Associated Locations</h4>
                <div class="space-y-4">
                    @forelse($serviceEvent->locations as $location)
                        <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                            <h5 class="text-lg font-bold text-gray-800 dark:text-gray-100">{{ $location->name }}</h5>
                            <p class="text-sm text-gray-600 dark:text-gray-300">{{ $location->address }}</p>
                            <p class="text-sm text-gray-600 dark:text-gray-300">City: {{ $location->city }}</p>
                            <p class="text-sm text-gray-600 dark:text-gray-300">
                                Next Service Date: 
                                @if($location->serviceEvents->isNotEmpty())
                                    <a href="{{ route('service-events.show', $location->serviceEvents->first()->id) }}" class="text-blue-500 hover:underline">
                                        {{ \Carbon\Carbon::parse($location->serviceEvents->first()->next_service_date)->format('d.m.Y') }}
                                    </a>
                                @else
                                    N/A
                                @endif
                            </p>
                            <p class="text-sm text-gray-600 dark:text-gray-300">
                                @if($serviceEvent->category == 'pp_device')
                                    Devices: {{ $location->devices->count() ?? 0 }}
                                @elseif($serviceEvent->category == 'hydrant')
                                    Hydrants: {{ $location->hydrants->count() ?? 0 }}
                                @endif
                            </p>
                            <p class="text-sm text-gray-600 dark:text-gray-300">
                                Company: 
                                @if($location->company)
                                    {{ $location->company->name }}
                                @else
                                    N/A
                                @endif
                            </p>
                            <!-- Link to Locations Index -->
                            <p class="mt-2">
                                {{-- <a href="{{ route('locations.index', $location->company->id) }}" class="text-blue-500 hover:underline">
                                    View Location Details
                                </a> --}}
                            </p>
                        </div>
                    @empty
                        <div class="text-center text-gray-500 dark:text-gray-300">No locations found</div>
                    @endforelse
                </div>
            </div>

            <!-- Back Button -->
            <div class="mt-6">
                <a href="{{ route('service-events.index') }}" class="text-blue-600 dark:text-blue-400 hover:underline">
                    &larr; Back to Service Events List
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
