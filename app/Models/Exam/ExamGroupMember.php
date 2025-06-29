<?php

namespace App\Models\Exam;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ExamGroupMember extends Model
{
    protected $fillable = ['exam_group_id', 'user_id', 'status', 'joined_at'];

    public function group(): BelongsTo
    {
        return $this->belongsTo(ExamGroup::class, 'exam_group_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function memberSubjects(): HasMany
    {
        return $this->hasMany(ExamMemberSubject::class);
    }
}
