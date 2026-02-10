<?php

namespace App\Livewire\School;

use App\Models\SchoolClass;
use App\Models\Subject;
use Livewire\Component;

class ManageClassSubjects extends Component
{
    public $classId;
    public $selectedSubjects = [];
    public $availableSubjects = [];

    public function mount($classId)
    {
        $this->classId = $classId;
        $class = SchoolClass::with('subjects')->findOrFail($classId);
        $this->selectedSubjects = $class->subjects->pluck('id')->toArray();
    }

    public function toggleSubject($subjectId)
    {
        if (auth()->user()->role !== 'school_admin') abort(403);

        $class = SchoolClass::findOrFail($this->classId);
        
        if (in_array($subjectId, $this->selectedSubjects)) {
            $class->subjects()->detach($subjectId);
            $this->selectedSubjects = array_diff($this->selectedSubjects, [$subjectId]);
        } else {
            $class->subjects()->attach($subjectId, ['is_compulsory' => true]);
            $this->selectedSubjects[] = $subjectId;
        }
    }

    public function render()
    {
        $class = SchoolClass::findOrFail($this->classId);
        $subjects = Subject::where('is_active', true)->get();

        return view('livewire.school.manage-class-subjects', compact('class', 'subjects'))
            ->layout('layouts.app')
            ->title('Manage Class Subjects');
    }
}
