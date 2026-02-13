<?php

namespace App\Livewire\Forms;

use App\Models\FeeCategory;
use Livewire\Component;

class FeeCategoryForm extends Component
{
    public $name, $description, $is_active = true, $categoryId;

    protected $rules = [
        'name' => 'required|string|max:255',
        'description' => 'nullable|string',
        'is_active' => 'boolean',
    ];

    public function mount($categoryId = null)
    {
        if ($categoryId) {
            $category = FeeCategory::where('school_id', auth()->user()->school_id)->findOrFail($categoryId);
            $this->categoryId = $category->id;
            $this->name = $category->name;
            $this->description = $category->description;
            $this->is_active = $category->is_active;
        }
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
            session()->flash('message', 'Fee category updated successfully.');
        } else {
            FeeCategory::create($data);
            session()->flash('message', 'Fee category created successfully.');
        }

        return redirect()->route('fee-categories.index');
    }

    public function render()
    {
        return view('livewire.forms.fee-category-form')
            ->layout('layouts.app');
    }
}
