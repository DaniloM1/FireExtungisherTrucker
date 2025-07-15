<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LocationCheck extends Model
{
    use HasFactory;

    protected $fillable = [
        'location_id',
        'type',
        'name',
        'description',
        'last_performed_date',
        'next_due_date',
        'inspector_id',
    ];
    protected $casts = [
        'last_performed_date' => 'date',      // ili 'datetime'
        'next_due_date'       => 'date',
    ];

    // Veza ka lokaciji
    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    // Veza ka inspektoru (korisniku)
    public function inspector()
    {
        return $this->belongsTo(User::class, 'inspector_id');
    }
}

