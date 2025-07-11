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

