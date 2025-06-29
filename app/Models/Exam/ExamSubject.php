<?php

namespace App\Models\Exam;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ExamSubject extends Model
{
    protected $fillable = ['name', 'education_level', 'description'];

    public function memberSubjects(): HasMany
    {
        return $this->hasMany(ExamMemberSubject::class);
    }

    public function announcements(): HasMany
    {
        return $this->hasMany(Announcement::class);
    }

    public function documents(): HasMany
    {
        return $this->hasMany(Document::class);
    }
}

