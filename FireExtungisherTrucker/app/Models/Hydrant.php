<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hydrant extends Model
{
    use HasFactory;

    protected $fillable = [
        'location_id',
        'serial_number',
        'type',
        'model',
        'manufacturer',
        'manufacture_date',
        'next_service_date',
        'position',
        'hvp',
        'static_pressure',
        'dynamic_pressure',
        'flow',
        'status',
    ];

    // Automatsko kastovanje datuma
    protected $casts = [
        'manufacture_date'   => 'date',
        'next_service_date'  => 'date',
        'hvp'                => 'date',
    ];

    /**
     * Veza: Hidranat pripada lokaciji.
     */
    public function location()
    {
        return $this->belongsTo(Location::class);
    }
}
