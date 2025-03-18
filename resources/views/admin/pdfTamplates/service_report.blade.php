<!DOCTYPE html>
<html lang="sr">
<head>
    <meta charset="utf-8">

    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            margin: 0;
            padding: 0;
            line-height: 1.4;
            color: #333;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .logo {
            max-height: 80px;
            margin-bottom: 10px;
        }
        .company {
            margin-bottom: 30px;
            page-break-inside: avoid;
        }
        .company h2 {
            margin: 0 0 5px;
            font-size: 16px;
        }
        .company-info {
            margin-bottom: 10px;
            font-size: 12px;
        }
        .company-info table {
            width: 100%;
            border-collapse: collapse;
        }
        .company-info th,
        .company-info td {
            padding: 4px;
            text-align: left;
            vertical-align: top;
        }
        .location {
            margin-top: 20px;
            page-break-inside: avoid;
        }
        .location h3 {
            font-size: 14px;
            background-color: #f2f2f2;
            padding: 5px;
            margin-bottom: 5px;
        }
        .section-title {
            font-size: 14px;
            margin: 10px 0 5px;
            color: #555;
            text-transform: uppercase;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
        }
        table, th, td {
            border: 0.5px solid #ccc;
        }
        th, td {
            padding: 5px;
            text-align: left;
            font-size: 11px;
        }
        th {
            background-color: #e2e2e2;
        }
    </style>
</head>
<body>
<div class="header">
    <p>Datum: {{ now()->format('d.m.Y.') }}</p>
</div>

@foreach($companies as $company)
    <div class="company">
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

        @foreach($company->locations as $location)
            <div class="location">
                <h3>{{ $location->name }} - {{ $location->city }}</h3>
                <p><strong>Adresa:</strong> {{ $location->address }}</p>

                <!-- Aparati (Devices) -->
                <p class="section-title">Aparati</p>
                @if($location->devices->count())
                    <table>
                        <thead>
                        <tr>
                            <th>Br</th>
                            <th>Tip</th>
                            <th style="width: 150px;">Proizvođač</th>

                            <th>Fab broj</th>
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
                                <td>{{ \Carbon\Carbon::parse($device->manufacture_date)->format('m/Y') }}</td>
                                <td>{{ \Carbon\Carbon::parse($device->hvp)->format('m/Y') }}</td>
                                <td>{{ $device->position }}</td>
                                <td>{{ ucfirst($device->status) }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                @else
                    <p>Nema aparata.</p>
                @endif

                <!-- Servisni Događaji -->
                <p class="section-title">Servisni događaji</p>
                @if($location->serviceEvents->count())
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
                        @foreach($location->serviceEvents->sortByDesc('service_date')->take(3) as $event)
                            <tr>
                                <td>{{ $event->evid_number }}</td>
                                <td>{{ \Carbon\Carbon::parse($event->service_date)->format('d.m.Y.') }}</td>
                                <td>{{ \Carbon\Carbon::parse($event->next_service_date)->format('d.m.Y.') }}</td>
                                <td>{{ $event->status }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                @else
                    <p>Nema servisnih događaja.</p>
                @endif

            </div>
        @endforeach
    </div>
@endforeach
</body>
</html>
