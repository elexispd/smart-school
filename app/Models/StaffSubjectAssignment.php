<?php

namespace App\Models;

use App\Traits\HasUuid;
use App\Traits\BelongsToSchool;
use Illuminate\Database\Eloquent\Model;

class StaffSubjectAssignment extends Model
{
    use HasUuid, BelongsToSchool;

    protected $guarded = ['id'];

    public function staff()
    {
        return $this->belongsTo(Staff::class);
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function schoolClass()
    {
        return $this->belongsTo(SchoolClass::class, 'class_id');
    }

    public function classArm()
    {
        return $this->belongsTo(ClassArm::class);
    }

    public function session()
    {
        return $this->belongsTo(Session::class);
    }
}
