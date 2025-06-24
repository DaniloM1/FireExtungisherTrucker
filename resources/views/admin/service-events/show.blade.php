<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            <i class="fas fa-tools mr-2 text-blue-500"></i>
            {{ __('Detalji Servisnog Događaja') }}
        </h2>
    </x-slot>

    <div class="py-6 bg-gray-100 dark:bg-gray-900 min-h-screen">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
            <!-- Back button -->
            <div>
                <a href="{{ route('dashboard') }}"
                   class="inline-flex items-center text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 transition-colors">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Nazad na servisne događaje
                </a>
            </div>

            <!-- Main Card -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden border border-gray-200 dark:border-gray-700">
                <!-- Card Header -->
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-700">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-bold text-gray-800 dark:text-gray-200">
                            Servis #{{ $serviceEvent->evid_number }}
                        </h3>
                        <span class="px-3 py-1 rounded-full text-xs font-semibold
                                    @if($serviceEvent->status === 'completed') bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200
                                    @elseif($serviceEvent->status === 'pending') bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200
                                    @else bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200 @endif">
                            {{ ucfirst($serviceEvent->status) }}
                        </span>
                    </div>
                </div>

                <!-- Card Body -->
                <div class="p-6">
                    <dl class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Left Column -->
                        <div class="space-y-4">
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 flex items-center">
                                    <i class="fas fa-calendar-day mr-2"></i> Datum servisa
                                </dt>
                                <dd class="mt-1 text-lg font-semibold text-gray-900 dark:text-gray-100">
                                    {{ \Carbon\Carbon::parse($serviceEvent->service_date)->format('d.m.Y') }}
                                </dd>
                            </div>

                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 flex items-center">
                                    <i class="fas fa-calendar-check mr-2"></i> Sledeći servis
                                </dt>
                                <dd class="mt-1 text-lg font-semibold text-gray-900 dark:text-gray-100">
                                    {{ $serviceEvent->next_service_date ? \Carbon\Carbon::parse($serviceEvent->next_service_date)->format('d.m.Y') : 'Nije definisan' }}
                                </dd>
                            </div>

                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 flex items-center">
                                    <i class="fas fa-tag mr-2"></i> Kategorija
                                </dt>
                                <dd class="mt-1 text-lg font-semibold text-gray-900 dark:text-gray-100">
                                    {{ ucfirst($serviceEvent->category) }}
                                </dd>
                            </div>
                        </div>

                        <!-- Right Column -->
                        <div class="space-y-4">
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 flex items-center">
                                    <i class="fas fa-money-bill-wave mr-2"></i> Trošak
                                </dt>
                                <dd class="mt-1 text-lg font-semibold text-gray-900 dark:text-gray-100">
                                    {{ number_format($serviceEvent->cost, 2, ',', '.') }} RSD
                                </dd>
                            </div>

                            @foreach($locationsGrouped as $companyName => $companyLocations)
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 flex items-center mt-4">
                                    <i class="fas fa-building mr-2"></i> {{ $companyName }}
                                </dt>
                                <dd class="mt-1 text-gray-900 dark:text-gray-100">
                                    <ul class="space-y-1">
                                        @foreach ($companyLocations as $loc)
                                            <li class="flex items-center">
                                                <i class="fas fa-circle text-xs text-blue-500 mr-2"></i>
                                                <a href="{{ auth()->user()->hasRole('company')
                                                       ? route('company.locations.show', $loc->id)
                                                       : route('locations.show', $loc->id) }}"

                                                   class="text-blue-600 dark:text-blue-400 hover:underline font-medium">
                                                    {{ $loc->name }}
                                                </a>
                                                <span class="ml-1 text-gray-600 dark:text-gray-300">({{ $loc->city }})</span>
                                            </li>
                                        @endforeach
                                    </ul>
                                </dd>
                            @endforeach



                        </div>

                        <!-- Full width description -->
                        <div class="md:col-span-2">
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 flex items-center">
                                <i class="fas fa-align-left mr-2"></i> Opis servisa
                            </dt>
                            <dd class="mt-2 p-4 bg-gray-50 dark:bg-gray-700 rounded-lg text-gray-800 dark:text-gray-200 whitespace-pre-line">
                                {{ $serviceEvent->description ?: 'Nema dodatnog opisa servisa.' }}
                            </dd>
                        </div>
                    </dl>
                </div>
            </div>

            <!-- Attachments Section -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden border border-gray-200 dark:border-gray-700">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-700">
                    <h3 class="text-lg font-bold text-gray-800 dark:text-gray-200 flex items-center">
                        <i class="fas fa-paperclip mr-2"></i>
                        Prilozi ({{ $serviceEvent->attachments->count() }})
                    </h3>
                </div>

                <div class="p-6">
                    @if($serviceEvent->attachments->count())
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @foreach($serviceEvent->attachments as $attachment)
                                <div class="flex items-center justify-between bg-gray-50 dark:bg-gray-700 rounded-lg p-4 border border-gray-200 dark:border-gray-600">
                                    <div class="flex items-center min-w-0">
                                        <i class="far fa-file-alt text-2xl text-gray-500 dark:text-gray-400 mr-3"></i>
                                        <div class="min-w-0">
                                            <a href="{{ asset('storage/'.$attachment->path) }}" target="_blank"
                                               class="text-blue-600 dark:text-blue-400 font-medium hover:underline truncate block">
                                                {{ $attachment->name }}
                                            </a>
                                            <span class="text-xs text-gray-500 dark:text-gray-400">{{ $attachment->type }}</span>
                                        </div>
                                    </div>
                                    <div class="flex items-center space-x-2">
                                        <a href="{{ asset('storage/'.$attachment->path) }}" target="_blank"
                                           class="text-blue-500 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300 p-1 rounded hover:bg-blue-50 dark:hover:bg-gray-600">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        @hasrole('super_admin|admin')
{{--                                            <a href="{{ route('service-events.attachments.edit', [$serviceEvent, $attachment]) }}"--}}
{{--                                               class="text-blue-500 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300 p-1 rounded hover:bg-blue-50 dark:hover:bg-gray-600">--}}
{{--                                                <i class="fas fa-edit"></i>--}}
{{--                                            </a>--}}
                                        <form action="{{ route('attachments.destroy', $attachment) }}" method="POST"
                                              onsubmit="return confirm('Da li ste sigurni da želite obrisati ovaj prilog?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="text-red-500 hover:text-red-700 dark:text-red-400 dark:hover:text-red-300 p-1 rounded hover:bg-red-50 dark:hover:bg-gray-600">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                        @endhasrole
                                    </div>
                                </div>
                            @endforeach
                        </div>

                    @else
                        <div class="text-center py-8">
                            <i class="fas fa-paperclip text-3xl text-gray-300 dark:text-gray-600 mb-2"></i>
                            <p class="text-gray-500 dark:text-gray-400">Nema priloga za ovaj servis.</p>
                        </div>
                    @endif

                    <!-- Upload Form -->
                        @hasrole('super_admin|admin')
                    <form action="{{ route('service-events.attachments.store', $serviceEvent) }}" method="POST" enctype="multipart/form-data" class="mt-6">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                            <div class="md:col-span-2">
                                <label for="attachment" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Odaberite fajl</label>
                                <input type="file" name="attachment" id="attachment" required
                                       class="block w-full text-sm text-gray-700 dark:text-gray-300
                                              file:mr-4 file:py-2 file:px-4
                                              file:rounded-lg file:border-0
                                              file:text-sm file:font-semibold
                                              file:bg-blue-50 file:text-blue-700
                                              dark:file:bg-blue-900 dark:file:text-blue-200
                                              hover:file:bg-blue-100 dark:hover:file:bg-blue-800
                                              transition-colors cursor-pointer" />
                            </div>

                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Naziv</label>
                                <input type="text" name="name" id="name" required
                                       class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200 dark:focus:border-blue-500 dark:focus:ring-blue-600"
                                       placeholder="Naziv dokumenta">
                            </div>

                            <div>
                                <label for="type" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Tip</label>
                                <input type="text" name="type" id="type" required
                                       class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200 dark:focus:border-blue-500 dark:focus:ring-blue-600"
                                       placeholder="Tip dokumenta">
                            </div>
                        </div>

                        <div class="mt-4">
                            <button type="submit"
                                    class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition-colors">
                                <i class="fas fa-upload mr-2"></i> Dodaj prilog
                            </button>
                        </div>

                        @if($errors->any())
                            <div class="mt-4 p-3 bg-red-50 dark:bg-red-900/20 rounded-lg">
                                @foreach($errors->all() as $error)
                                    <p class="text-sm text-red-600 dark:text-red-400">{{ $error }}</p>
                                @endforeach
                            </div>
                        @endif
                    </form>
                        @endif
                </div>
            </div>
        </div>
    </div>

    @push('styles')
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
    @endpush
</x-app-layout>
