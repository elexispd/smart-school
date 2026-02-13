<?php

namespace App\Livewire\Forms;

use App\Models\{FeeStructure, FeeCategory, Session, SchoolClass, ClassArm};
use Livewire\Component;

class FeeStructureForm extends Component
{
    public $fee_category_id, $session_id, $class_id, $class_arm_id, $amount, $payment_type = 'one_time', $is_active = true, $structureId;
    public $installments = [];
    public $categories, $sessions, $classes, $classArms = [];

    protected function rules()
    {
        return [
            'fee_category_id' => 'required|exists:fee_categories,id',
            'session_id' => 'required|exists:sessions,id',
            'class_id' => 'nullable|exists:classes,id',
            'class_arm_id' => 'nullable|exists:class_arms,id',
            'amount' => 'required|numeric|min:0',
            'payment_type' => 'required|in:one_time,installment',
            'is_active' => 'boolean',
            'installments.*.name' => 'required_if:payment_type,installment|string',
            'installments.*.percentage' => 'required_if:payment_type,installment|numeric|min:0|max:100',
            'installments.*.due_date' => 'nullable|date',
        ];
    }

    public function mount($structureId = null)
    {
        $schoolId = auth()->user()->school_id;
        $this->categories = FeeCategory::where('school_id', $schoolId)->where('is_active', true)->get();
        $this->sessions = Session::where('school_id', $schoolId)->get();
        $this->classes = SchoolClass::where('school_id', $schoolId)->where('is_active', true)->get();

        if ($structureId) {
            $structure = FeeStructure::with('installments')->where('school_id', $schoolId)->findOrFail($structureId);
            $this->structureId = $structure->id;
            $this->fee_category_id = $structure->fee_category_id;
            $this->session_id = $structure->session_id;
            $this->class_id = $structure->class_id;
            $this->class_arm_id = $structure->class_arm_id;
            $this->amount = $structure->amount;
            $this->payment_type = $structure->payment_type;
            $this->is_active = $structure->is_active;
            $this->installments = $structure->installments->map(fn($i) => [
                'name' => $i->name,
                'percentage' => $i->percentage,
                'due_date' => $i->due_date?->format('Y-m-d'),
            ])->toArray();
            if ($this->class_id) $this->updatedClassId($this->class_id);
        }
    }

    public function updatedClassId($value)
    {
        $this->classArms = $value ? ClassArm::where('class_id', $value)->where('is_active', true)->get() : [];
        if (!$this->classArms->contains('id', $this->class_arm_id)) $this->class_arm_id = null;
    }

    public function addInstallment()
    {
        $this->installments[] = ['name' => '', 'percentage' => '', 'due_date' => ''];
    }

    public function removeInstallment($index)
    {
        unset($this->installments[$index]);
        $this->installments = array_values($this->installments);
    }

    public function save()
    {
        $this->validate();

        if ($this->payment_type === 'installment' && array_sum(array_column($this->installments, 'percentage')) != 100) {
            session()->flash('error', 'Installment percentages must total 100%.');
            return;
        }

        $data = [
            'school_id' => auth()->user()->school_id,
            'fee_category_id' => $this->fee_category_id,
            'session_id' => $this->session_id,
            'class_id' => $this->class_id,
            'class_arm_id' => $this->class_arm_id,
            'amount' => $this->amount,
            'payment_type' => $this->payment_type,
            'is_active' => $this->is_active,
        ];

        if ($this->structureId) {
            $structure = FeeStructure::where('school_id', auth()->user()->school_id)->findOrFail($this->structureId);
            $structure->update($data);
            $structure->installments()->delete();
        } else {
            $structure = FeeStructure::create($data);
        }

        if ($this->payment_type === 'installment') {
            foreach ($this->installments as $index => $installment) {
                $structure->installments()->create([
                    'name' => $installment['name'],
                    'percentage' => $installment['percentage'],
                    'due_date' => $installment['due_date'] ?: null,
                    'order' => $index + 1,
                ]);
            }
        }

        session()->flash('message', 'Fee structure saved successfully.');
        return redirect()->route('fee-structures.index');
    }

    public function render()
    {
        return view('livewire.forms.fee-structure-form')
            ->layout('layouts.app');
    }
}
