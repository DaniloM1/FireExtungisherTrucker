<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Service Events') }}
        </h2>
    </x-slot>

    <div class="py-6 bg-gray-100 dark:bg-gray-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Success poruka -->
            @if(session('success'))
                <div class="bg-green-600 text-white p-4 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <div class="flex flex-col space-y-4">
                <!-- Header sekcija -->
                <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center">

                    <a href="{{ route('service-events.create') }}"
                       class="mt-4 sm:mt-0 inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none">
                        Create New Service Event
                    </a>
                </div>

                <!-- Desktop prikaz (tabela) -->
                <div class="hidden md:block bg-white dark:bg-gray-800 shadow rounded-lg overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                ID
                            </th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Category
                            </th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Service Date
                            </th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Next Service Date
                            </th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Evid Number
                            </th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Description
                            </th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Cost
                            </th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Actions
                            </th>
                        </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach($serviceEvents as $event)
                            <tr>
                                <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                    {{ $event->id }}
                                </td>
                                <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                    {{ ucfirst($event->category) }}
                                </td>
                                <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                    {{ $event->service_date->format('Y-m-d') }}
                                </td>
                                <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                    {{ $event->next_service_date->format('Y-m-d') }}
                                </td>
                                <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                    {{ $event->evid_number }}
                                </td>
                                <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                    {{ $event->description }}
                                </td>
                                <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                    {{ $event->cost }}
                                </td>
                                <td class="px-4 py-2 whitespace-nowrap text-sm">
                                    <div class="flex space-x-2">
                                        <a href="{{ route('service-events.edit', $event->id) }}" class="text-blue-600 dark:text-blue-400 hover:underline">
                                            Edit
                                        </a>
                                        <form action="{{ route('service-events.destroy', $event->id) }}" method="POST" onsubmit="return confirm('Are you sure?')" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 dark:text-red-400 hover:underline">
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Mobile prikaz (kartice) -->
                <div class="md:hidden space-y-4">
                    @foreach($serviceEvents as $event)
                        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-4">
                            <div class="flex justify-between items-center">
                                <h4 class="text-lg font-semibold text-gray-900 dark:text-gray-200">
                                    Event #{{ $event->id }}
                                </h4>
                                <div class="flex space-x-2">
                                    <a href="{{ route('service-events.edit', $event->id) }}" class="text-blue-600 dark:text-blue-400 hover:underline">
                                        Edit
                                    </a>
                                    <form action="{{ route('service-events.destroy', $event->id) }}" method="POST" onsubmit="return confirm('Are you sure?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 dark:text-red-400 hover:underline">
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </div>
                            <div class="mt-2 space-y-1">
                                <p class="text-sm text-gray-700 dark:text-gray-300">
                                    <strong>Category:</strong> {{ ucfirst($event->category) }}
                                </p>
                                <p class="text-sm text-gray-700 dark:text-gray-300">
                                    <strong>Service Date:</strong> {{ $event->service_date->format('Y-m-d') }}
                                </p>
                                <p class="text-sm text-gray-700 dark:text-gray-300">
                                    <strong>Next Service Date:</strong> {{ $event->next_service_date->format('Y-m-d') }}
                                </p>
                                <p class="text-sm text-gray-700 dark:text-gray-300">
                                    <strong>Evid Number:</strong> {{ $event->evid_number }}
                                </p>
                                <p class="text-sm text-gray-700 dark:text-gray-300">
                                    <strong>Description:</strong> {{ $event->description }}
                                </p>
                                <p class="text-sm text-gray-700 dark:text-gray-300">
                                    <strong>Cost:</strong> {{ $event->cost }}
                                </p>
                            </div>
                            <!-- Prikaz lokacija -->
                            @if($event->locations->isNotEmpty())
                                <div class="mt-3">
                                    <strong class="text-gray-900 dark:text-gray-200">Locations:</strong>
                                    <ul class="list-disc pl-5 mt-1 text-sm text-gray-700 dark:text-gray-300">
                                        @foreach($event->locations as $location)
                                            <li>{{ $location->name }} - {{ $location->city }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
