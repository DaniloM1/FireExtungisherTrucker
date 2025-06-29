<?php
namespace App\Models\Exam;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ExamGroup extends Model
{
    protected $fillable = ['name', 'start_date', 'exam_date'];

    public function members(): HasMany
    {
        return $this->hasMany(ExamGroupMember::class);
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
