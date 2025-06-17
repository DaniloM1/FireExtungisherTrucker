<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Attachment extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'path',
        'type',
        'location_id',
        'service_event_id'
    ];

    public function location() {

        return $this->belongsTo(Location::class);
    }

    public function serviceEvent() {

        return $this->belongsTo(ServiceEvent::class);
    }
}
