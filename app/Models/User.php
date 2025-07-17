<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Exam\Document;
use App\Models\Exam\ExamGroupMember;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;


    protected $fillable = [
        'name',
        'email',
        'password',
        'company_id',
        'education_level'

    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    public function company()
    {
        return $this->belongsTo(Company::class);
    }
    public function examGroupMembers()
    {
        return $this->hasMany(ExamGroupMember::class);
    }

    public function documents()
    {
        return $this->hasMany(Document::class, 'user_id');
    }
    public function getEducationLevelAttribute()
    {
        if (array_key_exists('education_level', $this->attributes)) {
            return $this->attributes['education_level'];
        }
        // Simuliraj random dok ne dodaš u migraciju
        return ['SSS', 'VSS'][array_rand(['SSS', 'VSS'])];
    }
    public function inspections()
    {
        return $this->hasMany(LocationCheck::class, 'inspector_id');
    }
    public function canViewAttachment(\App\Models\Attachment $attachment)
{
    return $this->hasAnyRole(['super_admin', 'company']);
}


}
