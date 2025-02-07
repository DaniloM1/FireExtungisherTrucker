<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    use HasFactory;

    // Polja koja se mogu masovno popunjavati
    protected $fillable = [
        'location_id',
        'group_id',
        'serial_number',
        'model',
        'manufacturer',
        'manufacture_date',
        'next_service_date',
        'position',
        'status',
    ];

    /**
     * Veza: Uređaj pripada lokaciji.
     */
    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    /**
     * Veza: Uređaj može pripadati grupi (opcionalno).
     */
    public function group()
    {
        return $this->belongsTo(Group::class);
    }
}
