@props([
    'locations',
    'title'         => 'Lokacije',
    'width'         => 'max-w-full',
    'height'        => 'h-64',
    'autoTheme'     => false,
    'mapId'         => null,
    'highlightIds'  => [],      //  <<< NOVO
])
@php
//    dd($highlightIds);
@endphp
<section {{ $attributes->merge([
    'class' => "bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg shadow-sm mx-auto p-6 sm:p-8 $width"
]) }}>
    <h2 class="mb-3 text-base font-semibold text-gray-700 dark:text-gray-200">
        {{ $title }}
    </h2>

    <div class="map-wrapper overflow-hidden rounded-md {{ $height }} border border-gray-300 dark:border-gray-600">
        <x-map
            :locations="$locations"
            :auto-theme="$autoTheme"
            :map-id="$mapId ?? 'leaflet-map-'.uniqid()"
            :highlight-ids="$highlightIds"   {{--  <<< NOVO  --}}
        />
    </div>
</section>
