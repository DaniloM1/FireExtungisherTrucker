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



    public function company()
    {
        return $this->belongsTo(Company::class);
    }
    public function groups()
    {
        return $this->hasMany(Group::class);
    }

    public function devices()
    {
        return $this->hasMany(Device::class);
    }



}
