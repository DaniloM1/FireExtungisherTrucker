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
        'city',
        'latitude',
        'longitude',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class)->withTrashed();
    }

    public function groups()
    {
        return $this->hasMany(Group::class);
    }

    public function devices() {
        return $this->hasMany(Device::class);
    }
    public function hydrants() {
        return $this->hasMany(Hydrant::class);
    }

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
    public function nextServiceDateByCategory($category)
    {
        return $this->serviceEvents
            ->where('category', $category) // filtriraš po tipu/kategoriji
            ->sortBy('next_service_date') // ručno sortiranje jer je kolekcija
            ->first()?->next_service_date;
    }
    public function attachments()
    {
        return $this->hasMany(Attachment::class);
    }




}
