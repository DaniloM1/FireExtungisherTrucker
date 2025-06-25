<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Company extends Model
{
    use HasFactory, softDeletes;

    protected $fillable = [
        'name',
        'address',
        'city',
        'contact_email',
        'contact_phone',
        'pib',
        'city',
        'maticni_broj',
        'website',
    ];

    public function locations()
    {
        return $this->hasMany(Location::class);
    }

    // public function devices()
    // {
    //     return $this->hasManyThrough(Device::class, Location::class);
    // }
    public function scopeSearch($query, $term)
    {
        $columns = ['name', 'contact_email', 'contact_phone', 'city'];
        $query->where(function($q) use ($term, $columns) {
            foreach ($columns as $col) {
                $q->orWhere($col, 'like', "%{$term}%");
            }
        });
    }
}
