{{--{{dd($flatLocations)}}--}}
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
                        <h3 class="text-lg font-bold text-gray-800 dark:text-gray-200 flex items-center gap-3">
                            Servis #{{ $serviceEvent->evid_number }}
                            @hasrole('super_admin|admin')
                            <a href="{{ route('service-report.generate', $serviceEvent->id) }}"
                               class="text-gray-600 dark:text-gray-300 hover:text-gray-900" title="Štampa">
                                <i class="fas fa-print"></i>
                            </a>

                            <a href="{{ route('service-events.edit', $serviceEvent->id) }}"
                               class="text-gray-600 dark:text-gray-300 hover:text-gray-900 ml-2" title="Uredi">
                                <i class="fas fa-edit"></i>
                            </a>
                            @endhasrole
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
                <div class="p-8">
                    <dl class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <!-- Left Column -->
                        <div class="md:col-span-1 space-y-4">
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
                                    {{ ['pp_device' => 'Aparati', 'hydrants' => 'Hidranti'][$serviceEvent->category] ?? ucfirst($service->category) }}
                                </dd>
                            </div>
                        </div>

                        <div class="md:col-span-2 space-y-2">
{{--                            <div>--}}
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 flex items-center">
                                     Kompanije/Lokacije
                                </dt>
                            @foreach($locationsGrouped as $companyName => $companyLocations)
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 flex items-center mt-4">
                                    <i class="fas fa-building mr-2"></i> {{ $companyName }}
                                </dt>
                                <dd class="mt-1 text-gray-900 dark:text-gray-100">
                                    <ul class="space-y-2">
                                        @foreach ($companyLocations as $loc)
                                            @php
                                                $sel = $loc->pivot ?? $loc->service_event_location ?? null;
                                            @endphp
                                            <li class="flex flex-col md:flex-row md:items-center gap-2 md:gap-4 py-1 border-b last:border-none border-gray-100 dark:border-gray-700">
                                                <div class="flex items-center">
                                                    <i class="fas fa-circle text-xs text-blue-500 mr-2"></i>
                                                    <a href="{{ auth()->user()->hasRole('company')
                                                            ? route('company.locations.show', $loc->id)
                                                            : route('locations.show', $loc->id) }}"
                                                       class="text-blue-600 dark:text-blue-400 hover:underline font-medium">
                                                        {{ $loc->name }}
                                                    </a>
                                                    <span class="ml-1 text-gray-600 dark:text-gray-300">({{ $loc->city }})</span>
                                                    @if($sel && $sel->status !== 'done')
                                                    @hasrole('super_admin')
                                                        <form method="POST" action="{{ route('service-events.locations.complete', [$serviceEvent->id, $loc->id]) }}" class="d-inline js-complete-location-form">
                                                            @csrf
                                                            <button type="button"
                                                                    class="bg-green-600 hover:bg-green-700 text-white rounded-full w-8 h-8 flex items-center justify-center shadow transition ml-2 js-complete-location"
                                                                    title="Označi lokaciju kao završenu"
                                                                    data-location="{{ $loc->name }}">
                                                                <i class="fas fa-check"></i>
                                                            </button>
                                                        </form>
                                                        @endhasrole
                                                    @else
                                                        <span class="ml-2 px-2 py-1 rounded-full text-xs bg-green-100 text-green-700">Završeno</span>
                                                        @if($sel && $sel->completed_at)
                                                            <span class="ml-2 text-xs text-gray-500">({{ \Carbon\Carbon::parse($sel->completed_at)->format('d.m.Y H:i') }})</span>
                                                        @endif
                                                    @endif

                                                </div>
                                                <div class="flex-1">
                                                    <span class="text-xs text-gray-500 dark:text-gray-400">Prilozi: {{ $loc->attachments->count() }}</span>
                                                </div>
                                                @hasrole('super_admin|admin')
                                                <div x-data="{ showAttachForm: false }" class="flex items-center">
                                                    <button
                                                        @click="showAttachForm = !showAttachForm"
                                                        class="bg-blue-600 hover:bg-blue-700 text-white rounded-full w-8 h-8 flex items-center justify-center shadow transition ml-2"
                                                        title="Dodaj prilog za ovu lokaciju i servis"
                                                        type="button"
                                                    >
                                                        <i class="fas fa-plus"></i>
                                                    </button>
                                                    <!-- Forma za upload -->
                                                    <div x-show="showAttachForm" class="absolute mt-2 z-50 bg-white dark:bg-gray-800 rounded shadow-lg border p-4" @click.away="showAttachForm = false" style="min-width: 280px;">
                                                        <form action="{{ route('service-events.locations.attachments.store', [$serviceEvent->id, $loc->id]) }}" method="POST" enctype="multipart/form-data" class="space-y-3">
                                                            @csrf
                                                            <div>
                                                                <label for="attachment_{{ $serviceEvent->id }}_{{ $loc->id }}" class="block text-xs font-medium text-gray-700 dark:text-gray-300">Fajl</label>
                                                                <input type="file" name="attachment" id="attachment_{{ $serviceEvent->id }}_{{ $loc->id }}" required
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
                                                                <label for="name_{{ $serviceEvent->id }}_{{ $loc->id }}" class="block text-xs font-medium text-gray-700 dark:text-gray-300">Naziv</label>
                                                                <input type="text" name="name" id="name_{{ $serviceEvent->id }}_{{ $loc->id }}" class="block w-full mt-1 rounded border-gray-300 dark:bg-gray-700 dark:text-gray-200" placeholder="Naziv dokumenta" required>
                                                            </div>
                                                            <div>
                                                                <label for="type_{{ $serviceEvent->id }}_{{ $loc->id }}" class="block text-xs font-medium text-gray-700 dark:text-gray-300">Tip</label>
                                                                <input type="text" name="type" id="type_{{ $serviceEvent->id }}_{{ $loc->id }}" class="block w-full mt-1 rounded border-gray-300 dark:bg-gray-700 dark:text-gray-200" placeholder="Tip dokumenta (pdf, slika...)" required>
                                                            </div>
                                                            <div class="flex justify-end">
                                                                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded text-xs">
                                                                    <i class="fas fa-upload mr-1"></i> Dodaj
                                                                </button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                                @endhasrole
                                                <!-- Prilozi lista -->
                                                @if($loc->attachments->count())
                                                    <div class="w-full md:w-auto flex flex-wrap gap-2 mt-2 md:mt-0">
                                                        @foreach($loc->attachments as $attachment)
                                                            <div class="flex items-center bg-gray-100 dark:bg-gray-700 px-2 py-1 rounded text-xs">
                                                                <a href="{{ asset('storage/'.$attachment->path) }}" target="_blank" class="text-blue-700 dark:text-blue-300 hover:underline font-medium truncate max-w-[140px]">{{ $attachment->name }}</a>
                                                                @hasrole('super_admin|admin')
                                                                <form action="{{ route('attachments.destroy', $attachment) }}" method="POST" class="ml-1"
                                                                      onsubmit="return confirm('Obrisati prilog?')">
                                                                    @csrf @method('DELETE')
                                                                    <button type="submit" class="text-red-500 hover:text-red-700 ml-1" title="Obriši">
                                                                        <i class="fas fa-trash"></i>
                                                                    </button>
                                                                </form>
                                                                @endhasrole
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                @endif
                                            </li>
                                        @endforeach
                                    </ul>
                                </dd>
                            @endforeach
                        </div>
                        <!-- Full width description -->
                        <div class="md:col-span-3">
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

            <!-- Attachments Section za servis događaj -->
@include('admin.service-events.attachments-section')
        </div>
    </div>
    @php
        $doneIds = $serviceEvent
     ->locations()                    // ← obrati pažnju na zagrade: query builder
     ->wherePivot('status', 'done')   // filtriraj u JOIN-u
     ->pluck('locations.id')          // Idi kolonu iz glavne tabele
     ->toArray();                     // običan niz
//dd($doneIds);
    @endphp

    <x-map-card
        :locations="$serviceEvent->locations->toArray()"
        title="Lokacije"
        width="max-w-4xl"
        height="h-200"
        :highlightIds="$doneIds"
    />
    @push('styles')
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
    @endpush
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('.js-complete-location').forEach(function(btn) {
                btn.addEventListener('click', function (e) {
                    e.preventDefault();
                    let form = btn.closest('form');
                    let locationName = btn.getAttribute('data-location') || 'ovu lokaciju';

                    // Detekcija dark/light mode-a
                    let isDark = document.documentElement.classList.contains('dark');

                    Swal.fire({
                        title: 'Da li ste sigurni?',
                        text: `Ova akcija će označiti ${locationName} kao završenu.`,
                        icon: 'question',
                        background: isDark ? '#1f2937' : '#fff', // gray-800 : white
                        color: isDark ? '#e5e7eb' : '#111827',   // gray-200 : gray-900
                        showCancelButton: true,
                        confirmButtonColor: isDark ? '#16a34a' : '#198754', // green-600 : bootstrap green
                        cancelButtonColor: isDark ? '#ef4444' : '#d33',      // red-500 : sweetalert red
                        confirmButtonText: 'Da, završi!',
                        cancelButtonText: 'Otkaži',
                        customClass: {
                            popup: isDark ? 'swal2-dark' : ''
                        }
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                });
            });
        });
    </script>



</x-app-layout>
