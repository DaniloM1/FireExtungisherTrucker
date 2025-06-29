<?php

namespace App\Models\Exam;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DocumentType extends Model
{
    protected $fillable = ['code', 'name', 'description'];

    public function documents(): HasMany
    {
        return $this->hasMany(Document::class);
    }
}

