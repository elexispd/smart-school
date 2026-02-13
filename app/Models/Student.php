<?php

namespace App\Models;

use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\DB;

class Student extends Model
{
    use HasUuid;
    protected $guarded = ['id'];

    protected $casts = [
        'date_of_birth' => 'date',
        'admission_date' => 'date',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function school(): BelongsTo
    {
        return $this->belongsTo(School::class);
    }

    public function currentClass(): BelongsTo
    {
        return $this->belongsTo(SchoolClass::class, 'current_class_id');
    }

    public function classArm(): BelongsTo
    {
        return $this->belongsTo(ClassArm::class);
    }

    public function payments()
    {
        return $this->hasMany(StudentPayment::class);
    }

    public function electiveSubjects()
    {
        return $this->belongsToMany(Subject::class, 'student_subject', 'student_id', 'subject_id')
            ->withPivot('type')
            ->withTimestamps();
    }

    /**
     * Get all subjects for this student (optimized query)
     * Combines: class compulsory + class arm specific + student electives
     */
    public function getAllSubjects()
    {
        if (!$this->current_class_id) {
            return collect();
        }

        // Get class compulsory subjects
        $classSubjects = DB::table('class_subject')
            ->where('class_id', $this->current_class_id)
            ->where('is_compulsory', true)
            ->pluck('subject_id');

        // Get class arm specific subjects
        $classArmSubjects = collect();
        if ($this->class_arm_id) {
            $classArmSubjects = DB::table('class_arm_subject')
                ->where('class_arm_id', $this->class_arm_id)
                ->pluck('subject_id');
        }

        // Get student elective subjects
        $electiveSubjects = DB::table('student_subject')
            ->where('student_id', $this->id)
            ->pluck('subject_id');

        // Merge and get unique subject IDs
        $allSubjectIds = $classSubjects
            ->merge($classArmSubjects)
            ->merge($electiveSubjects)
            ->unique();

        // Return subjects with metadata
        return Subject::whereIn('id', $allSubjectIds)
            ->where('is_active', true)
            ->get()
            ->map(function ($subject) use ($classSubjects, $classArmSubjects, $electiveSubjects) {
                $subject->source = [];
                if ($classSubjects->contains($subject->id)) {
                    $subject->source[] = 'class_compulsory';
                }
                if ($classArmSubjects->contains($subject->id)) {
                    $subject->source[] = 'class_arm';
                }
                if ($electiveSubjects->contains($subject->id)) {
                    $subject->source[] = 'elective';
                }
                return $subject;
            });
    }
}
