<?php
namespace App\Models\Exam;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ExamMemberSubject extends Model
{
    protected $fillable = [
        'exam_group_member_id',
        'exam_subject_id',
        'status',
        'unlocked_at',
        'result_date'
    ];

    public function groupMember(): BelongsTo
    {
        return $this->belongsTo(ExamGroupMember::class, 'exam_group_member_id');
    }

    public function subject(): BelongsTo
    {
        return $this->belongsTo(ExamSubject::class, 'exam_subject_id');
    }
}
