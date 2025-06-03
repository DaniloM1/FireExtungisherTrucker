<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory;
    protected $fillable = [
        'location_id',
        'name',
        'description',
    ];

    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    public function devices()
    {
        return $this->hasMany(Device::class);
    }
}
