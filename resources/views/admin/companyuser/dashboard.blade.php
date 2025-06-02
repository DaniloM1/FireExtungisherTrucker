<h2>Moje Lokacije</h2>
<ul>
    @foreach($locations as $location)
        <li>{{ $location->name }} ({{ $location->devices_count }} uređaja, {{ $location->hydrants_count }} hidranta)</li>
    @endforeach
</ul>

<h2>Servisni Događaji</h2>
<ul>
    @foreach($serviceEvents as $event)
        <li>{{ $event->category }} - {{ $event->service_date }} - {{ $event->evid_number }}</li>
    @endforeach
</ul>
