<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    // Definišemo koje kolone se mogu masovno dodeljivati
    protected $fillable = [
        'name',
        'address',
        'contact_email',
        'contact_phone',
        'pib',
        'maticni_broj',
        'website',
    ];

    // Definisanje odnosa sa lokacijama
    public function locations()
    {
        return $this->hasMany(Location::class);
    }

    // Definisanje odnosa sa grupama uređaja
//    public function deviceGroups()
//    {
//        return $this->hasMany(DeviceGroup::class);
//    }
//    public function users()
//    {
//        return $this->hasMany(User::class);
//    }
//    public function devices()
//    {
//        return $this->hasManyThrough(Device::class, Location::class);
//    }

}

