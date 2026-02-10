<?php

namespace App\Models;

use App\Traits\HasUuid;
use App\Traits\BelongsToSchool;
use Illuminate\Database\Eloquent\Model;

class SchoolClass extends Model
{
    use HasUuid, BelongsToSchool;

    protected $table = 'classes';
    protected $guarded = ['id'];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function classArms()
    {
        return $this->hasMany(ClassArm::class, 'class_id');
    }

    public function subjects()
    {
        return $this->belongsToMany(Subject::class, 'class_subject', 'class_id', 'subject_id')
            ->withPivot('is_compulsory')
            ->withTimestamps();
    }

    public function compulsorySubjects()
    {
        return $this->subjects()->wherePivot('is_compulsory', true);
    }

    public function electiveSubjects()
    {
        return $this->subjects()->wherePivot('is_compulsory', false);
    }
}
