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
        'city', // Dodato polje za grad
        'contact_email',
        'contact_phone',
        'pib',
        'city',
        'maticni_broj',
        'website',
    ];

    // Definisanje odnosa sa lokacijama
    public function locations()
    {
        return $this->hasMany(Location::class);
    }

    // Ukoliko kasnije budeš želeo da pristupiš uređajima kroz kompaniju,
    // možeš koristiti hasManyThrough odnos:
    // public function devices()
    // {
    //     return $this->hasManyThrough(Device::class, Location::class);
    // }
}
