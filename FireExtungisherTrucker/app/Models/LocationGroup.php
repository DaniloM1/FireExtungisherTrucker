<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LocationGroup extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
    ];

    /**
     * Veza: Lokacijska grupa može sadržati više lokacija.
     */
    public function locations()
    {
        return $this->belongsToMany(Location::class, 'location_group_members');
    }
}
