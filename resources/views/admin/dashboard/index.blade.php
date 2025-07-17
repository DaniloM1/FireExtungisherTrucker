<x-app-layout>
    <div x-data="{
        tab: (new URLSearchParams(window.location.search)).get('tab') || 'overview',
        setTab(newTab) {
            this.tab = newTab;
            const url = new URL(window.location);
            url.searchParams.set('tab', newTab);
            window.history.pushState(null, '', url);
        }
    }">
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-900 dark:text-gray-100 leading-tight">Dashboard</h2>
        </x-slot>

        <div class="mt-4 border-b border-gray-200 dark:border-gray-700">
            <nav class="-mb-px flex justify-center space-x-3 sm:space-x-4 whitespace-nowrap">
                <button @click="setTab('overview')" 
                    :class="tab === 'overview' ? 'border-blue-500 text-blue-500' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'" 
                    class="py-4 px-1 border-b-2 font-medium text-sm flex items-center justify-center">
                    <i class="fas fa-chart-bar text-lg"></i>
                </button>
                <button @click="setTab('services')" 
                    :class="tab === 'services' ? 'border-blue-500 text-blue-500' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'" 
                    class="py-4 px-1 border-b-2 font-medium text-sm flex items-center justify-center">
                    <i class="fas fa-tools text-lg"></i>
                </button>
                <button @click="setTab('inspections')" 
                    :class="tab === 'inspections' ? 'border-blue-500 text-blue-500' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'" 
                    class="py-4 px-1 border-b-2 font-medium text-sm flex items-center justify-center">
                    <i class="fas fa-search text-lg"></i>
                </button>
                <button @click="setTab('calendar')" 
                    :class="tab === 'calendar' ? 'border-blue-500 text-blue-500' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'" 
                    class="py-4 px-1 border-b-2 font-medium text-sm flex items-center justify-center">
                    <i class="fas fa-calendar-alt text-lg"></i>
                </button>
                <button @click="setTab('companies')" 
                    :class="tab === 'companies' ? 'border-blue-500 text-blue-500' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'" 
                    class="py-4 px-1 border-b-2 font-medium text-sm flex items-center justify-center">
                    <i class="fas fa-building text-lg"></i>
                </button>
                <button @click="setTab('trends')" 
                    :class="tab === 'trends' ? 'border-blue-500 text-blue-500' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'" 
                    class="py-4 px-1 border-b-2 font-medium text-sm flex items-center justify-center">
                    <i class="fas fa-chart-line text-lg"></i>
                </button>
            </nav>
        </div>
        

        <!-- Glavni sadržaj -->
        <div class="py-6">
            <div class="max-w-7xl mx-auto sm:px-4 lg:px-6">

<div x-show="tab === 'overview'" class="space-y-6">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Nadolazeći servisi -->
        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-4">
            <div class="text-3xl font-bold text-gray-900 dark:text-gray-100">
                {{ $serviceEvents->count() }}
            </div>
            <div class="text-sm text-gray-500">Nadolazećih servisa</div>
        </div>
        <!-- Nadolazeće inspekcije -->
        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-4">
            <div class="text-3xl font-bold text-gray-900 dark:text-gray-100">
                {{ $locationChecks->count() }}
            </div>
            <div class="text-sm text-gray-500">Nadolazećih inspekcija</div>
        </div>
        <!-- Kompanije koje zahtevaju servis -->
        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-4">
            <div class="text-3xl font-bold text-gray-900 dark:text-gray-100">
                {{ $companiesNeedingService->count() }}
            </div>
            <div class="text-sm text-gray-500">Kompanije za servis</div>
        </div>
    </div>

    <!-- Nova sekcija: Servis po gradovima -->
    <div class="mt-8">
        <h3 class="text-2xl font-semibold text-gray-900 dark:text-gray-100 mb-4">
            Servis po gradovima
        </h3>

        <div class="space-y-4">

            @foreach($citySummaries as $city => $summary)
    @php
        $locations = $cities[$city] ?? collect();
    @endphp
    <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-4">
        <div class="flex flex-col md:flex-row md:justify-between md:items-center space-y-2 md:space-y-0">
            <h4 class="text-xl font-bold text-gray-900 dark:text-gray-100">
                {{ $city }}
            </h4>
            <div class="text-sm text-gray-600 dark:text-gray-300">
                <span class="font-semibold">{{ $summary['event_count'] }}</span> događaja<br class="md:hidden">
                <span class="hidden md:inline">•</span> Najbliži servis:
                <span class="font-semibold">
                    {{ $summary['next_service_date'] ? $summary['next_service_date']->format('d.m.Y') : 'N/A' }}
                </span>
            </div>
        </div>

        <ul class="list-disc pl-5 mt-2 text-gray-700 dark:text-gray-300">

            @foreach($locations as $location)
                <li>
                    <span class="font-semibold">{{ $location->name }}</span>
                    @if(isset($location->computed_next_service_date))
                        - <span class="text-sm">Sledeći servis: {{ \Carbon\Carbon::parse($location->computed_next_service_date)->format('d.m.Y') }}</span>
                    @else
                        <!-- Ovde možete staviti neki alternativni sadržaj ili ostaviti prazno -->


                    - <span class="text-sm">Sledeći servis: N/A</span>
                    @endif
                    @if($location->company)
                        - <span class="text-sm">{{ $location->company->name }}</span>
                    @endif
                </li>
            @endforeach
        </ul>

    </div>
@endforeach

        </div>
    </div>
</div>


                <!-- Servisi -->
                <div x-show="tab === 'services'" class="py-6 bg-gray-100 dark:bg-gray-900">
                    @include('admin.service-events._list')

                </div>

                <!-- Inspekcije -->
                <div x-show="tab === 'inspections'" class="mt-6 space-y-6">
                    <h3 class="text-2xl font-semibold text-gray-900 dark:text-gray-100 mb-4">
                        Nadolazeće Inspekcije i Testovi
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @forelse ($locationChecks as $check)
                            <div
                                class="bg-white dark:bg-gray-800 shadow rounded-lg p-4 cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-700"
                                onclick="window.location='{{ route('location_checks.show', $check->id) }}'"
                            >
                                <div class="flex items-center justify-between">
                    <span class="text-lg font-bold text-gray-900 dark:text-gray-100">
                        ID: {{ $check->id }}
                    </span>
                                    <span
                                        class="px-2 py-0.5 rounded text-xs font-medium
                               {{ $check->type === 'test' ? 'bg-amber-500 text-white' : 'bg-green-600 text-white' }}">
                        {{ ucfirst($check->type) }}
                    </span>
                                </div>

                                <div class="mt-2 text-sm text-gray-700 dark:text-gray-300">
                                    <div>
                                        Poslednja: {{ optional($check->last_performed_date)->format('d.m.Y') ?? '‑' }}
                                    </div>
                                    <div>
                                        Sledeća: {{ optional($check->next_due_date)->format('d.m.Y') ?? '‑' }}
                                    </div>
                                </div>

                                <div class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                                    <span class="font-medium">{{ $check->location->name }}</span>
                                    @if($check->location->company)
                                        <span>({{ $check->location->company->name }})</span>
                                    @endif
                                    <span> – {{ $check->location->city }}</span>
                                </div>
                            </div>
                        @empty
                            <div class="col-span-full text-center text-gray-700 dark:text-gray-300">
                                Nema nadolazećih pregleda.
                            </div>
                        @endforelse
                    </div>
                </div>

                <div x-show="tab === 'trends'" class="mt-6 space-y-6">
    <h3 class="text-2xl font-semibold text-gray-900 dark:text-gray-100 mb-4">
        Service Trends (naredna 3 meseca)
    </h3>

    <div class="flex flex-col md:flex-row md:space-x-4 space-y-4 md:space-y-0">
        <!-- Grafikoni -->
        <div class="w-full md:w-1/2 bg-white dark:bg-gray-800 p-4 rounded-lg shadow">
            <canvas id="combinedChart"></canvas>
        </div>
        <!-- Desna kolona: Tabela s podacima -->
        <div class="w-full md:w-1/2 bg-white dark:bg-gray-800 p-4 rounded-lg shadow">
            <table class="min-w-full text-sm">
                <thead>
                    <tr>
                        <th class="py-1 px-2 border-b border-gray-200 text-gray-900 dark:text-gray-100 mb-4 text-center">Mesec</th>
                        <th class="py-1 px-2 border-b border-gray-200 text-gray-900 dark:text-gray-100 mb-4 text-center">Ukupno aparata</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($deviceTrends as $trend)
                        <tr>
                            <td class="py-1 px-2 border-b border-gray-200 text-gray-900 dark:text-gray-100 mb-4 text-center">
                                {{ \Carbon\Carbon::createFromDate($trend['year'], $trend['month'])->format('F Y') }}
                            </td>
                            <td class="py-1 px-2 border-b border-gray-200 text-gray-900 dark:text-gray-100 mb-4 text-center">
                                {{ $trend['total_devices'] }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <!-- Tabela sa trendovima -->
    <div class="overflow-x-auto">
        <table class="min-w-full bg-white dark:bg-gray-800 shadow rounded-lg">
            <thead>
                <tr>
                    <th class="py-2 px-4 border-b border-gray-200 dark:border-gray-700 text-left text-sm font-semibold text-gray-700 dark:text-gray-300">Godina</th>
                    <th class="py-2 px-4 border-b border-gray-200 dark:border-gray-700 text-left text-sm font-semibold text-gray-700 dark:text-gray-300">Mesec</th>
                    <th class="py-2 px-4 border-b border-gray-200 dark:border-gray-700 text-left text-sm font-semibold text-gray-700 dark:text-gray-300">Broj događaja</th>
                    <th class="py-2 px-4 border-b border-gray-200 dark:border-gray-700 text-left text-sm font-semibold text-gray-700 dark:text-gray-300">Akcije</th>
                </tr>
            </thead>
            <tbody>
                @foreach($serviceTrends as $trend)
                    <tr>
                        <td class="py-2 px-4 border-b border-gray-200 dark:border-gray-700 text-sm text-gray-700 dark:text-gray-300">
                            {{ $trend->year }}
                        </td>
                        <td class="py-2 px-4 border-b border-gray-200 dark:border-gray-700 text-sm text-gray-700 dark:text-gray-300">
                            {{ \Carbon\Carbon::createFromDate($trend->year, $trend->month)->format('F') }}
                        </td>
                        <td class="py-2 px-4 border-b border-gray-200 dark:border-gray-700 text-sm text-gray-700 dark:text-gray-300">
                            {{ $trend->count }}
                        </td>
                        <td class="py-2 px-4 border-b border-gray-200 dark:border-gray-700 text-sm">
                            <a href="{{ route('service-events.index', ['year' => $trend->year, 'month' => $trend->month]) }}" class="text-blue-600 dark:text-blue-400 hover:underline">
                                Pretraži
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>


</div>

                <!-- Kompanije -->
                <div x-show="tab === 'companies'" class="mt-6 space-y-6">
                    <h3 class="text-2xl font-semibold text-gray-900 dark:text-gray-100 mb-4">
                        Kompanije koje zahtevaju servis
                    </h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                        @forelse ($companiesNeedingService as $company)
                            <a href="{{ route('companies.locations.index', $company->id) }}"
                               class="block bg-white dark:bg-gray-800 shadow rounded-lg p-4 hover:bg-gray-50 dark:hover:bg-gray-700">
                                <div class="text-lg font-bold text-gray-900 dark:text-gray-100">
                                    {{ $company->name }}
                                </div>
                                <div class="mt-1 text-sm text-gray-600 dark:text-gray-300">
                                    {{ $company->city }}<br>
                                    PIB: {{ $company->pib }}
                                </div>
                                <div class="mt-1 text-sm text-gray-600 dark:text-gray-300">
                                    Sledeći servis:
                                    @if($company->next_service_date)
                                        {{ \Carbon\Carbon::parse($company->next_service_date)->format('d.m.Y') }}
                                    @else
                                        N/A
                                    @endif
                                </div>
                            </a>
                        @empty
                            <div class="col-span-full text-center text-gray-700 dark:text-gray-300">
                                Nema kompanija koje zahtevaju servis.
                            </div>
                        @endforelse
                    </div>
                </div>
                <div x-show="tab === 'calendar'" class="mt-6 space-y-6">
                    <x-calendar :events="$importantDates" />
                </div>


            </div>
        </div>
    </div>


    </div>

    <script>
        function toggleAccordion(eventId) {
            let element = document.getElementById('accordion-' + eventId);
            element.classList.toggle('hidden');
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>

        // Kombinovani chart sa lazy loadingom
        document.addEventListener("DOMContentLoaded", function() {
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting && !window.chartInitialized) {
                        window.chartInitialized = true;
                        initializeCharts();
                    }
                });
            }, { threshold: 0.1 });

            observer.observe(document.getElementById('combinedChart'));

            function initializeCharts() {
                const ctx = document.getElementById('combinedChart').getContext('2d');

                // Podaci iz kontrolera
                const serviceData = {!! json_encode($serviceTrends->toArray()) !!};
                const deviceData = {!! json_encode($deviceTrends) !!};

                new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: serviceData.map(t => `${t.month}/${t.year}`),
                        datasets: [{
                            label: 'Servisni događaji',
                            data: serviceData.map(t => t.count),
                            backgroundColor: 'rgba(54, 162, 235, 0.6)',
                            borderColor: 'rgba(54, 162, 235, 1)',
                            borderWidth: 1
                        },
                        {
                            label: 'Aktivni uređaji',
                            data: deviceData.map(t => t.total_devices),
                            backgroundColor: 'rgba(75, 192, 192, 0.6)',
                            borderColor: 'rgba(75, 192, 192, 1)',
                            borderWidth: 1,
                            type: 'line',
                            yAxisID: 'y1'
                        }]
                    },
                    options: {
                        responsive: true,
                        scales: {
                            y: {
                                beginAtZero: true,
                                title: { display: true, text: 'Servisi' }
                            },
                            y1: {
                                position: 'right',
                                beginAtZero: true,
                                title: { display: true, text: 'Uređaji' },
                                grid: { drawOnChartArea: false }
                            }
                        },
                        plugins: {
                            legend: { position: 'bottom' }
                        }
                    }
                });
            }
        });

        // Accordion funkcija
        function toggleAccordion(eventId) {
            const element = document.getElementById(`accordion-${eventId}`);
            element.classList.toggle('hidden');
        }
    </script>
</x-app-layout>
