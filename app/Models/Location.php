<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id',
        'name',
        'address',
        'city',       // Dodato polje za grad
        'latitude',
        'longitude',
    ];

    /**
     * Veza: Lokacija pripada jednoj kompaniji.
     */
    public function company()
    {
        return $this->belongsTo(Company::class)->withTrashed();
    }

    /**
     * Veza: Lokacija ima više grupa uređaja.
     */
    public function groups()
    {
        return $this->hasMany(Group::class);
    }

    /**
     * Veza: Lokacija ima više uređaja.
     */
    public function devices() {
        return $this->hasMany(Device::class);
    }
    public function hydrants() {
        return $this->hasMany(Hydrant::class);
    }


    /**
     * Veza: Lokacija može biti deo više location grupa.
     */
    public function locationGroups()
    {
        return $this->belongsToMany(LocationGroup::class, 'location_group_members');
    }

    public function serviceEvents()
    {
        return $this->belongsToMany(ServiceEvent::class, 'service_event_locations')->orderBy('next_service_date', 'asc');
    }

    public function getNextServiceDateAttribute()
    {
        return $this->serviceEvents->first() ? $this->serviceEvents->first()->next_service_date : null;
    }



}
