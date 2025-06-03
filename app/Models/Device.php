<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    use HasFactory;

    protected $fillable = [
        'location_id',
        'group_id',
        'serial_number',
        'model',
        'manufacturer',
        'manufacture_date',
        'next_service_date',
        'position',
        'hvp',
        'status',
    ];

    protected $casts = [
        'manufacture_date' => 'date',
        'next_service_date' => 'date',
        'hvp' => 'date',
    ];


    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    public function group()
    {
        return $this->belongsTo(Group::class);
    }
}
