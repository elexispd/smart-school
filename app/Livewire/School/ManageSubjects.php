<?php

namespace App\Livewire\School;

use App\Models\Subject;
use Livewire\Component;
use Livewire\WithPagination;

class ManageSubjects extends Component
{
    use WithPagination;

    public $search = '';
    public $viewMode = 'grid';
    public $showModal = false;
    public $showDeleteModal = false;
    public $subjectId;
    public $name;
    public $code;
    public $description;
    public $is_active = true;

    protected $rules = [
        'name' => 'required|min:2',
        'code' => 'nullable|string|max:10',
        'description' => 'nullable',
        'is_active' => 'boolean',
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function create()
    {
        if (auth()->user()->role !== 'school_admin') abort(403);
        
        $this->reset(['name', 'code', 'description', 'is_active', 'subjectId']);
        $this->is_active = true;
        $this->showModal = true;
    }

    public function edit($id)
    {
        if (auth()->user()->role !== 'school_admin') abort(403);
        
        $subject = Subject::findOrFail($id);
        $this->subjectId = $id;
        $this->name = $subject->name;
        $this->code = $subject->code;
        $this->description = $subject->description;
        $this->is_active = $subject->is_active;
        $this->showModal = true;
    }

    public function save()
    {
        if (auth()->user()->role !== 'school_admin') abort(403);
        
        $this->validate();

        if ($this->subjectId) {
            Subject::findOrFail($this->subjectId)->update([
                'name' => $this->name,
                'code' => $this->code,
                'description' => $this->description,
                'is_active' => $this->is_active,
            ]);
        } else {
            Subject::create([
                'name' => $this->name,
                'code' => $this->code,
                'description' => $this->description,
                'is_active' => $this->is_active,
            ]);
        }

        $this->closeModal();
    }

    public function delete($id)
    {
        if (auth()->user()->role !== 'school_admin') abort(403);
        
        $this->subjectId = $id;
        $this->showDeleteModal = true;
    }

    public function confirmDelete()
    {
        if (auth()->user()->role !== 'school_admin') abort(403);
        
        Subject::findOrFail($this->subjectId)->delete();
        $this->showDeleteModal = false;
        $this->reset(['subjectId']);
    }

    public function toggleStatus($id)
    {
        if (auth()->user()->role !== 'school_admin') abort(403);
        
        $subject = Subject::findOrFail($id);
        $subject->update(['is_active' => !$subject->is_active]);
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->showDeleteModal = false;
        $this->reset(['name', 'code', 'description', 'is_active', 'subjectId']);
    }

    public function render()
    {
        $subjects = Subject::query()
            ->when($this->search, fn($q) => $q->where('name', 'like', '%' . $this->search . '%')
                ->orWhere('code', 'like', '%' . $this->search . '%'))
            ->latest()
            ->paginate(10);

        return view('livewire.school.manage-subjects', compact('subjects'))
            ->layout('layouts.app')
            ->title('Manage Subjects');
    }
}
