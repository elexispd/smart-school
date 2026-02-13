<?php

namespace App\Livewire\School;

use App\Models\StaffSubjectAssignment;
use App\Models\Staff;
use App\Models\Subject;
use App\Models\SchoolClass;
use App\Models\ClassArm;
use App\Models\Session;
use Livewire\Component;
use Livewire\WithPagination;

class ManageStaffAssignments extends Component
{
    use WithPagination;

    public $search = '';
    public $filterSession = '';
    public $filterTerm = '';
    public $showModal = false;
    public $showDeleteModal = false;
    public $showViewModal = false;
    public $assignmentId;
    public $viewingAssignments = [];
    public $staff_id, $subject_id, $class_id, $class_arm_id, $session_id, $term;
    public $selectedAssignments = [];
    public $errorMessage = '';

    protected $rules = [
        'staff_id' => 'required|exists:staff,id',
        'session_id' => 'required|exists:academic_sessions,id',
        'term' => 'required|in:First Term,Second Term,Third Term',
        'selectedAssignments' => 'required|array|min:1',
        'selectedAssignments.*.subject_id' => 'required|exists:subjects,id',
        'selectedAssignments.*.class_id' => 'required|exists:classes,id',
        'selectedAssignments.*.class_arm_id' => 'required|exists:class_arms,id',
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatedSelectedAssignments($value, $key)
    {
        // Extract the index from the key (e.g., "0.class_id" -> 0)
        $parts = explode('.', $key);
        if (count($parts) === 2 && $parts[1] === 'class_id') {
            $index = $parts[0];
            $this->selectedAssignments[$index]['class_arm_id'] = null;
        }
    }

    public function create()
    {
        if (auth()->user()->role !== 'school_admin') abort(403);
        
        $this->reset(['staff_id', 'session_id', 'term', 'selectedAssignments', 'assignmentId']);
        $this->selectedAssignments = [['subject_id' => null, 'class_id' => null, 'class_arm_id' => null]];
        $this->showModal = true;
    }

    public function addAssignment()
    {
        $this->selectedAssignments[] = ['subject_id' => null, 'class_id' => null, 'class_arm_id' => null];
    }

    public function removeAssignment($index)
    {
        unset($this->selectedAssignments[$index]);
        $this->selectedAssignments = array_values($this->selectedAssignments);
    }

    public function save()
    {
        if (auth()->user()->role !== 'school_admin') abort(403);
        
        $this->validate();

        $currentSession = Session::where('is_current', true)->first();
        
        if (!$currentSession) {
            $this->errorMessage = 'No current session set.';
            return;
        }

        $session = Session::findOrFail($this->session_id);
        
        // Compare session names (e.g., "2024/2025" vs "2025/2026")
        if ($session->name < $currentSession->name) {
            $this->errorMessage = 'Cannot assign to previous sessions.';
            return;
        }

        // Check if trying to assign to previous term in current session
        if ($session->id === $currentSession->id) {
            $termOrder = [
                'first' => 1, 'First Term' => 1,
                'second' => 2, 'Second Term' => 2,
                'third' => 3, 'Third Term' => 3
            ];
            $currentTermValue = $termOrder[$currentSession->current_term] ?? 0;
            $selectedTermValue = $termOrder[$this->term] ?? 0;
            
            if ($selectedTermValue < $currentTermValue) {
                $this->errorMessage = 'Cannot assign to previous terms.';
                return;
            }
        }

        foreach ($this->selectedAssignments as $assignment) {
            StaffSubjectAssignment::updateOrCreate(
                [
                    'staff_id' => $this->staff_id,
                    'subject_id' => $assignment['subject_id'],
                    'class_arm_id' => $assignment['class_arm_id'],
                    'session_id' => $this->session_id,
                    'term' => $this->term,
                ],
                [
                    'school_id' => auth()->user()->school_id,
                    'class_id' => $assignment['class_id'],
                ]
            );
        }

        $this->closeModal();
    }

    public function delete($id)
    {
        if (auth()->user()->role !== 'school_admin') abort(403);
        
        $assignment = StaffSubjectAssignment::with('session')->findOrFail($id);
        $currentSession = Session::where('is_current', true)->first();
        
        if (!$currentSession) {
            session()->flash('error', 'No current session set.');
            return;
        }

        // Compare session names (e.g., "2024/2025" vs "2025/2026")
        if ($assignment->session->name < $currentSession->name) {
            session()->flash('error', 'Cannot delete assignments from previous sessions.');
            return;
        }

        // Check if trying to delete from previous term in current session
        if ($assignment->session_id === $currentSession->id) {
            $termOrder = [
                'first' => 1, 'First Term' => 1,
                'second' => 2, 'Second Term' => 2,
                'third' => 3, 'Third Term' => 3
            ];
            $currentTermValue = $termOrder[$currentSession->current_term] ?? 0;
            $assignmentTermValue = $termOrder[$assignment->term] ?? 0;
            
            if ($assignmentTermValue < $currentTermValue) {
                session()->flash('error', 'Cannot delete assignments from previous terms.');
                return;
            }
        }
        
        $this->assignmentId = $id;
        $this->showDeleteModal = true;
    }

    public function confirmDelete()
    {
        if (auth()->user()->role !== 'school_admin') abort(403);
        
        StaffSubjectAssignment::findOrFail($this->assignmentId)->delete();
        $this->showDeleteModal = false;
        $this->reset(['assignmentId']);
    }

    public function view($staffId, $sessionId)
    {
        $assignments = StaffSubjectAssignment::with(['subject', 'schoolClass', 'classArm'])
            ->where('staff_id', $staffId)
            ->where('session_id', $sessionId)
            ->get();

        $this->viewingAssignments = $assignments->groupBy('term')->map(function($items) {
            return $items->map(function($item) {
                return [
                    'id' => $item->id,
                    'subject_name' => $item->subject->name,
                    'class_name' => $item->schoolClass->name,
                    'class_arm_name' => $item->classArm->name,
                ];
            })->toArray();
        })->toArray();
        
        $this->showViewModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->showDeleteModal = false;
        $this->showViewModal = false;
        $this->reset(['staff_id', 'session_id', 'term', 'selectedAssignments', 'assignmentId', 'viewingAssignments', 'errorMessage']);
    }

    public function render()
    {
        $staffFilter = request('staff');
        
        $query = StaffSubjectAssignment::with(['staff.user', 'session'])
            ->when($this->search, fn($q) => $q->whereHas('staff.user', fn($query) => 
                $query->where('name', 'like', '%' . $this->search . '%')
            ))
            ->when($staffFilter, fn($q) => $q->whereHas('staff', fn($query) => 
                $query->where('user_id', $staffFilter)
            ))
            ->when($this->filterSession, fn($q) => $q->where('session_id', $this->filterSession))
            ->when($this->filterTerm, fn($q) => $q->where('term', $this->filterTerm))
            ->get();

        $assignments = $query->groupBy(function($item) {
                return $item->staff_id . '-' . $item->session_id;
            })
            ->map(function($group) {
                $first = $group->first();
                return (object) [
                    'staff_id' => $first->staff_id,
                    'session_id' => $first->session_id,
                    'staff_name' => $first->staff->user->name,
                    'session_name' => $first->session->name,
                    'count' => $group->count(),
                ];
            })
            ->values();

        $staff = Staff::with('user')->whereHas('user')->get();
        $subjects = Subject::where('is_active', true)->get();
        $classes = SchoolClass::where('is_active', true)->get();
        $sessions = Session::all();

        return view('livewire.school.manage-staff-assignments', compact('assignments', 'staff', 'subjects', 'classes', 'sessions'))
            ->layout('layouts.app')
            ->title('Teacher Subject Assignments');
    }
}
