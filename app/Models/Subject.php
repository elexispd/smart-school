<?php

namespace App\Models;

use App\Traits\HasUuid;
use App\Traits\BelongsToSchool;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasUuid, BelongsToSchool;

    protected $guarded = ['id'];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function classes()
    {
        return $this->belongsToMany(SchoolClass::class, 'class_subject', 'subject_id', 'class_id')
            ->withPivot('is_compulsory')
            ->withTimestamps();
    }

    public function classArms()
    {
        return $this->belongsToMany(ClassArm::class, 'class_arm_subject', 'subject_id', 'class_arm_id')
            ->withPivot('is_compulsory')
            ->withTimestamps();
    }

    public function students()
    {
        return $this->belongsToMany(Student::class, 'student_subject', 'subject_id', 'student_id')
            ->withPivot('type')
            ->withTimestamps();
    }

    public function staffAssignments()
    {
        return $this->hasMany(StaffSubjectAssignment::class);
    }
}
