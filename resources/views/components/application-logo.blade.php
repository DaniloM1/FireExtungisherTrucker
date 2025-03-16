@props(['color' => 'black'])

@if($color === 'black')
    <img src="{{ asset('images/logo-white.svg') }}" alt="Logo" width="80" height="90">
@else
    <img src="{{ asset('images/logo.svg') }}" alt="Logo" width="80" height="90">
@endif
