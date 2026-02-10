<?php

namespace App\Livewire\School;

use App\Models\ClassArm;
use App\Models\SchoolClass;
use Livewire\Component;
use Livewire\WithPagination;

class ManageClassArms extends Component
{
    use WithPagination;

    public $search = '';
    public $classFilter = '';
    public $selectedClassId = null;
    public $showModal = false;
    public $showDeleteModal = false;
    public $classArmId;
    public $class_id;
    public $name;
    public $capacity;
    public $is_active = true;

    protected $rules = [
        'class_id' => 'required|exists:classes,id',
        'name' => 'required|min:1',
        'capacity' => 'nullable|integer|min:1',
        'is_active' => 'boolean',
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function create()
    {
        if (auth()->user()->role !== 'school_admin') abort(403);
        
        $this->reset(['name', 'capacity', 'is_active', 'classArmId', 'class_id']);
        $this->is_active = true;
        $this->showModal = true;
    }

    public function edit($id)
    {
        if (auth()->user()->role !== 'school_admin') abort(403);
        
        $classArm = ClassArm::findOrFail($id);
        $this->classArmId = $id;
        $this->class_id = $classArm->class_id;
        $this->name = $classArm->name;
        $this->capacity = $classArm->capacity;
        $this->is_active = $classArm->is_active;
        $this->showModal = true;
    }

    public function save()
    {
        if (auth()->user()->role !== 'school_admin') abort(403);
        
        $this->validate();

        if ($this->classArmId) {
            ClassArm::findOrFail($this->classArmId)->update([
                'class_id' => $this->class_id,
                'name' => $this->name,
                'capacity' => $this->capacity,
                'is_active' => $this->is_active,
            ]);
        } else {
            ClassArm::create([
                'class_id' => $this->class_id,
                'name' => $this->name,
                'capacity' => $this->capacity,
                'is_active' => $this->is_active,
            ]);
        }

        $this->closeModal();
    }

    public function delete($id)
    {
        if (auth()->user()->role !== 'school_admin') abort(403);
        
        $this->classArmId = $id;
        $this->showDeleteModal = true;
    }

    public function confirmDelete()
    {
        if (auth()->user()->role !== 'school_admin') abort(403);
        
        ClassArm::findOrFail($this->classArmId)->delete();
        $this->showDeleteModal = false;
        $this->reset(['classArmId']);
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->showDeleteModal = false;
        $this->reset(['name', 'capacity', 'is_active', 'classArmId', 'class_id']);
    }

    public function render()
    {
        $classArms = ClassArm::query()
            ->with(['schoolClass', 'schoolClass.subjects'])
            ->withCount('subjects')
            ->when($this->search, fn($q) => $q->where('name', 'like', '%' . $this->search . '%'))
            ->when($this->classFilter, fn($q) => $q->where('class_id', $this->classFilter))
            ->when($this->selectedClassId, fn($q) => $q->where('class_id', $this->selectedClassId))
            ->latest()
            ->paginate(10);

        $classes = SchoolClass::where('is_active', true)->withCount('classArms')->get();

        return view('livewire.school.manage-class-arms', compact('classArms', 'classes'))
            ->layout('layouts.app')
            ->title('Manage Class Arms');
    }
}
