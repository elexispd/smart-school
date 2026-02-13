<?php

namespace App\Livewire\School;

use App\Models\FeeCategory;
use Livewire\Component;
use Livewire\WithPagination;

class ManageFeeCategories extends Component
{
    use WithPagination;

    public $search = '';
    public $viewMode = 'grid';
    public $showModal = false;
    public $showDeleteModal = false;
    public $categoryId, $name, $description, $is_active = true;

    protected $rules = [
        'name' => 'required|string|max:255',
        'description' => 'nullable|string',
        'is_active' => 'boolean',
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function create()
    {
        $this->reset(['name', 'description', 'categoryId']);
        $this->is_active = true;
        $this->showModal = true;
    }

    public function edit($id)
    {
        $category = FeeCategory::where('school_id', auth()->user()->school_id)->findOrFail($id);
        $this->categoryId = $id;
        $this->name = $category->name;
        $this->description = $category->description;
        $this->is_active = $category->is_active;
        $this->showModal = true;
    }

    public function save()
    {
        $this->validate();

        $data = [
            'school_id' => auth()->user()->school_id,
            'name' => $this->name,
            'description' => $this->description,
            'is_active' => $this->is_active,
        ];

        if ($this->categoryId) {
            FeeCategory::where('school_id', auth()->user()->school_id)->findOrFail($this->categoryId)->update($data);
        } else {
            FeeCategory::create($data);
        }

        $this->closeModal();
        session()->flash('message', 'Fee category saved successfully.');
    }

    public function delete($id)
    {
        $this->categoryId = $id;
        $this->showDeleteModal = true;
    }

    public function confirmDelete()
    {
        FeeCategory::where('school_id', auth()->user()->school_id)->findOrFail($this->categoryId)->delete();
        $this->showDeleteModal = false;
        $this->reset(['categoryId']);
        session()->flash('message', 'Fee category deleted successfully.');
    }

    public function toggleStatus($id)
    {
        $category = FeeCategory::where('school_id', auth()->user()->school_id)->findOrFail($id);
        $category->update(['is_active' => !$category->is_active]);
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->showDeleteModal = false;
        $this->reset(['name', 'description', 'categoryId']);
        $this->is_active = true;
    }

    public function render()
    {
        $categories = FeeCategory::where('school_id', auth()->user()->school_id)
            ->when($this->search, fn($q) => $q->where('name', 'like', '%' . $this->search . '%'))
            ->latest()
            ->paginate(10);
        return view('livewire.school.manage-fee-categories', compact('categories'))
            ->layout('layouts.app')
            ->title('Fee Categories');
    }
}
