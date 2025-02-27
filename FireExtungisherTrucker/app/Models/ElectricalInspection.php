<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ElectricalInspection extends Model
{
    use HasFactory;

    protected $fillable = [
        'location_id',
        'inspection_date',
        'next_inspection_date',
        'description',
        'cost',
    ];

    // Automatsko kastovanje datuma
    protected $casts = [
        'inspection_date'      => 'date',
        'next_inspection_date' => 'date',
    ];

    /**
     * Veza: Elektro inspekcija pripada lokaciji.
     */
    public function location()
    {
        return $this->belongsTo(Location::class);
    }
}
