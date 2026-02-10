<?php

namespace App\Models;

use App\Traits\HasUuid;
use App\Traits\BelongsToSchool;
use Illuminate\Database\Eloquent\Model;

class ClassArm extends Model
{
    use HasUuid, BelongsToSchool;

    protected $guarded = ['id'];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function schoolClass()
    {
        return $this->belongsTo(SchoolClass::class, 'class_id');
    }

    public function subjects()
    {
        return $this->belongsToMany(Subject::class, 'class_arm_subject', 'class_arm_id', 'subject_id')
            ->withPivot('is_compulsory')
            ->withTimestamps();
    }

    public function students()
    {
        return $this->hasMany(Student::class, 'class_arm_id');
    }
}
