<?php

namespace App\Livewire\School;

use App\Models\ClassArm;
use App\Models\Subject;
use Livewire\Component;

class ManageClassArmSubjects extends Component
{
    public $classArm;
    public $assignedSubjectIds = [];
    public $classSubjectIds = [];

    public function mount($classArmId)
    {
        $this->classArm = ClassArm::with('schoolClass.subjects')->findOrFail($classArmId);
        $this->assignedSubjectIds = $this->classArm->subjects()->pluck('subjects.id')->toArray();
        $this->classSubjectIds = $this->classArm->schoolClass->subjects()->pluck('subjects.id')->toArray();
    }

    public function toggleSubject($subjectId)
    {
        // Prevent toggling inherited class subjects
        if (in_array($subjectId, $this->classSubjectIds)) {
            return;
        }

        if (in_array($subjectId, $this->assignedSubjectIds)) {
            $this->classArm->subjects()->detach($subjectId);
            $this->assignedSubjectIds = array_diff($this->assignedSubjectIds, [$subjectId]);
        } else {
            $this->classArm->subjects()->attach($subjectId, ['is_compulsory' => true]);
            $this->assignedSubjectIds[] = $subjectId;
        }

        session()->flash('message', 'Subject assignment updated successfully.');
    }

    public function render()
    {
        $subjects = Subject::where('school_id', auth()->user()->school_id)
            ->where('is_active', true)
            ->orderBy('name')
            ->get();

        return view('livewire.school.manage-class-arm-subjects', [
            'subjects' => $subjects,
        ])->layout('layouts.app');
    }
}
