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
        'latitude',
        'longitude',
    ];

    // Odnos prema kompaniji
    public function company()
    {
        return $this->belongsTo(Company::class);
    }
//
//    // Odnos prema pozicijama
//    public function positions()
//    {
//        return $this->hasMany(Position::class);
//    }
//
//    // Odnos prema inventaru
//    public function inventory()
//    {
//        return $this->hasMany(Inventory::class);
//    }
//    public function devices()
//    {
//        return $this->hasMany(Device::class);
//    }


}
