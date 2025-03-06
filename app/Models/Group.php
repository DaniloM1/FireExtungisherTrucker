<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory;

    // Polja koja se mogu masovno popunjavati; izbačeno je next_service_date jer se servis evidentira odvojeno
    protected $fillable = [
        'location_id',
        'name',
        'description',
    ];

    /**
     * Veza: Grupa pripada lokaciji.
     */
    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    /**
     * Veza: Grupa ima više uređaja.
     */
    public function devices()
    {
        return $this->hasMany(Device::class);
    }
}
