<?php

namespace App\Livewire\School;

use App\Models\SchoolClass;
use Livewire\Component;
use Livewire\WithPagination;

class ManageClasses extends Component
{
    use WithPagination;

    public $search = '';
    public $viewMode = 'grid';
    public $showModal = false;
    public $showDeleteModal = false;
    public $classId;
    public $name;
    public $code;
    public $category;
    public $description;
    public $is_active = true;

    protected $rules = [
        'name' => 'required|min:2',
        'code' => 'nullable|string|max:10|unique:classes,code',
        'category' => 'required|in:nursery,primary,junior_secondary,senior_secondary',
        'description' => 'nullable',
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function create()
    {
        if (auth()->user()->role !== 'school_admin') abort(403);
        
        $this->reset(['name', 'code', 'category', 'description', 'classId']);
        $this->is_active = true;
        $this->showModal = true;
    }

    public function edit($id)
    {
        if (auth()->user()->role !== 'school_admin') abort(403);
        
        $class = SchoolClass::findOrFail($id);
        $this->classId = $id;
        $this->name = $class->name;
        $this->code = $class->code;
        $this->category = $class->category;
        $this->description = $class->description;
        $this->is_active = $class->is_active;
        $this->showModal = true;
    }

    public function save()
    {
        if (auth()->user()->role !== 'school_admin') abort(403);
        
        $rules = $this->rules;
        if ($this->classId) {
            $rules['code'] = 'nullable|string|max:10|unique:classes,code,' . $this->classId;
        }
        $this->validate($rules);

        if ($this->classId) {
            SchoolClass::findOrFail($this->classId)->update([
                'name' => $this->name,
                'code' => $this->code,
                'category' => $this->category,
                'description' => $this->description,
                'is_active' => $this->is_active,
            ]);
        } else {
            SchoolClass::create([
                'name' => $this->name,
                'code' => $this->code,
                'category' => $this->category,
                'description' => $this->description,
                'is_active' => $this->is_active,
            ]);
        }

        $this->closeModal();
    }

    public function delete($id)
    {
        if (auth()->user()->role !== 'school_admin') abort(403);
        
        $this->classId = $id;
        $this->showDeleteModal = true;
    }

    public function confirmDelete()
    {
        if (auth()->user()->role !== 'school_admin') abort(403);
        
        SchoolClass::findOrFail($this->classId)->delete();
        $this->showDeleteModal = false;
        $this->reset(['classId']);
    }

    public function toggleStatus($id)
    {
        if (auth()->user()->role !== 'school_admin') abort(403);
        
        $class = SchoolClass::findOrFail($id);
        $class->update(['is_active' => !$class->is_active]);
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->showDeleteModal = false;
        $this->reset(['name', 'code', 'category', 'description', 'classId']);
        $this->is_active = true;
    }

    public function render()
    {
        $classes = SchoolClass::query()
            ->when($this->search, fn($q) => $q->where('name', 'like', '%' . $this->search . '%'))
            ->withCount(['classArms', 'subjects'])
            ->latest()
            ->paginate(10);

        return view('livewire.school.manage-classes', compact('classes'))
            ->layout('layouts.app')
            ->title('Manage Classes');
    }
}
