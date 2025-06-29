<?php
namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class MapCard extends Component
{
    public string $mapId;

    public function __construct(
        public $locations,          // obavezan prop
        public string $title = 'Lokacije',
        public bool   $autoTheme = true,
        public string $width = 'max-w-xl',   // Tailwind klasa
        public string $height = 'h-72',      // Tailwind klasa
        string $mapId = null
    ) {
        $this->mapId = $mapId ?? 'leaflet-map-' . uniqid();
    }

    public function render(): View
    {
        return view('components.map-card');
    }
}

