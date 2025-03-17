<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceEvent extends Model
{
    use HasFactory;

    protected $fillable = [
        'category',
        'service_date',
        'next_service_date',
        'evid_number',
        'user_id',
        'description',
        'cost',
        'status',
    ];

    // Automatsko kastovanje datuma
    protected $casts = [
        'service_date'      => 'date',
        'next_service_date' => 'date',
    ];

    /**
     * Veza: Servisni događaj može biti vezan za više lokacija.
     */
    public function locations()
    {
        return $this->belongsToMany(Location::class, 'service_event_locations')
            ->withPivot('description', 'status')
            ->withTimestamps();
    }
    

}
