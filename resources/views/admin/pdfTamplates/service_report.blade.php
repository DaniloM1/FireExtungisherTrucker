<!DOCTYPE html>
<html lang="sr">
<head>
    <meta charset="utf-8">
    <style>
        body {
            font-family: DejaVu Sans, Arial, sans-serif;
            font-size: 11px;
            margin: 18px;
            color: #222;
        }
        .header { text-align: center; margin-bottom: 12px; }
        /*.company {*/
        /*    margin-bottom: 20px;*/
        /*    page-break-inside: avoid;*/
        /*    !* Sledeći red možeš zakomentarisati ako ne želiš svaku kompaniju na novoj strani: *!*/
        /*    !* page-break-before: always; *!*/
        /*}*/
        /*.company-info { margin-bottom: 6px; }*/
        /*.location {*/
        /*    margin-top: 8px;*/
        /*    margin-bottom: 10px;*/
        /*    page-break-inside: avoid;*/
        /*}*/
        .section-title {
            font-size: 12px;
            margin: 7px 0 3px;
            color: #333;
            font-weight: bold;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 8px;
            page-break-inside: auto;
        }
        th, td {
            border: 1px solid #aaa;
            padding: 3px 5px;
            font-size: 10px;
            text-align: left;
        }
        th {
            background: #f5f5f5;
            font-weight: bold;
        }
        tr { page-break-inside: avoid; }
        /* Ako hoćeš svaki company na novoj strani, otkomentariši: */
        /* .company { page-break-before: always; } */
    </style>

</head>
<body>
{{--<div class="header">--}}
{{--    <p>Datum: {{ now()->format('d.m.Y.') }}</p>--}}
{{--</div>--}}
@php
    $category = $serviceEvent->category ?? null;
@endphp

@foreach($companies as $company)
    @foreach($company->locations as $location)
        <div class="company" style="page-break-before: always;">
            <h2>{{ $company->name }}</h2>
            <div class="company-info">
                <table>
                    <tr>
                        <td><strong>Adresa:</strong> {{ $company->address }}</td>
                        <td><strong>Email:</strong> {{ $company->contact_email }}</td>
                    </tr>
                    <tr>
                        <td><strong>Telefon:</strong> {{ $company->contact_phone }}</td>
                        <td><strong>Grad:</strong> {{ $company->city }}</td>
                    </tr>
                    <tr>
                        <td><strong>PIB:</strong> {{ $company->pib }}</td>
                        <td><strong>Matični broj:</strong> {{ $company->maticni_broj }}</td>
                    </tr>
                    @if($company->website)
                        <tr>
                            <td colspan="2"><strong>Websajt:</strong> {{ $company->website }}</td>
                        </tr>
                    @endif
                </table>
            </div>

            <div class="location">
                <h3>{{ $location->name }} - {{ $location->city }}</h3>
                <p><strong>Adresa:</strong> {{ $location->address }}</p>
                <ul style="margin:0 0 8px 0; padding:0; list-style: none;">
                    @if(!empty($location->contact))
                        <li><strong>Kontakt osoba:</strong> {{ $location->contact }}</li>
                    @endif
                    @if(!empty($location->kontakt_broj))
                        <li><strong>Telefon:</strong> {{ $location->kontakt_broj }}</li>
                    @endif
                    @if(!empty($location->pib))
                        <li><strong>PIB:</strong> {{ $location->pib }}</li>
                    @endif
                    @if(!empty($location->maticni))
                        <li><strong>Matični broj:</strong> {{ $location->maticni }}</li>
                    @endif
                </ul>

                @if($category === 'hydrant')
                    <p class="section-title">Hidranti</p>
                    @if($location->hydrants->count())
                        <table>
                            <thead>
                            <tr>
                                <th>Br</th>
                                <th>Tip</th>
                                <th>Proizvođač</th>
                                <th>Fab. broj</th>
                                <th>Godina</th>
                                <th>HVP</th>
                                <th>Pozicija</th>
                                <th>Protok</th>
                                <th>Stat. pritisak</th>
                                <th>Din. pritisak</th>
                                <th>Status</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($location->hydrants as $hydrant)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $hydrant->type }}</td>
                                    <td>{{ $hydrant->manufacturer }}</td>
                                    <td>{{ $hydrant->serial_number }}</td>
                                    <td>
                                        @if(!empty($hydrant->manufacture_date))
                                            {{ \Carbon\Carbon::parse($hydrant->manufacture_date)->format('Y') }}
                                        @endif
                                    </td>
                                    <td>
                                        @if(!empty($hydrant->hvp))
                                            {{ \Carbon\Carbon::parse($hydrant->hvp)->format('Y') }}
                                        @endif
                                    </td>
                                    <td>{{ $hydrant->position }}</td>
                                    <td>{{ $hydrant->static_pressure }}</td>
                                    <td>{{ $hydrant->dynamic_pressure }}</td>
                                    <td>{{ $hydrant->flow }}</td>
                                    <td>
                                        {{ $hydrant->status == 'needs_service' ? 'Potreban HVP' : ucfirst($hydrant->status) }}
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    @else
                        <p>Nema hidranta.</p>
                    @endif

                @else
                    <p class="section-title">Aparati</p>
                    @if($location->devices->count())
                        <table>
                            <thead>
                            <tr>
                                <th>Br</th>
                                <th>Tip</th>
                                <th>Proizvođač</th>
                                <th>Fab. broj</th>
                                <th>Proizveden</th>
                                <th>HVP</th>
                                <th>Pozicija</th>
                                <th>Status</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($location->devices as $device)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $device->model }}</td>
                                    <td>{{ $device->manufacturer }}</td>
                                    <td>{{ $device->serial_number }}</td>
                                    <td>
                                        @if(!empty($device->manufacture_date))
                                            {{ \Carbon\Carbon::parse($device->manufacture_date)->format('Y') }}
                                        @endif
                                    </td>
                                    <td>
                                        @if(!empty($device->next_service_date))
                                            {{ \Carbon\Carbon::parse($device->next_service_date)->format('Y') }}
                                        @endif
                                    </td>
                                    <td>{{ $device->position }}</td>
                                    <td>
                                        {{ $device->status == 'needs_service' ? 'Potreban HVP' : ucfirst($device->status) }}
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    @else
                        <p>Nema aparata.</p>
                    @endif
                @endif

                <p class="section-title">Servisni događaji</p>
                @php
                    $targetCategory = $serviceEvent->category ?? null;
                    $filteredEvents = $location->serviceEvents
                        ->where('category', $targetCategory)
                        ->sortByDesc('service_date')
                        ->take(3);
                @endphp
                @if($filteredEvents->count())
                    <table>
                        <thead>
                        <tr>
                            <th>Evidentni broj</th>
                            <th>Datum servisa</th>
                            <th>Datum narednog servisa</th>
                            <th>Status</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($filteredEvents as $event)
                            <tr>
                                <td>{{ $event->evid_number }}</td>
                                <td>
                                    @if(!empty($event->service_date))
                                        {{ \Carbon\Carbon::parse($event->service_date)->format('d.m.Y.') }}
                                    @endif
                                </td>
                                <td>
                                    @if(!empty($event->next_service_date))
                                        {{ \Carbon\Carbon::parse($event->next_service_date)->format('d.m.Y.') }}
                                    @endif
                                </td>
                                <td>{{ ucfirst($event->status) }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                @else
                    <p>Nema servisnih događaja.</p>
                @endif

            </div>
        </div>
    @endforeach
@endforeach



</body>
</html>
