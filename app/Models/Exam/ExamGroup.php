<?php
namespace App\Models\Exam;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class ExamGroup extends Model
{
    use HasFactory;
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
