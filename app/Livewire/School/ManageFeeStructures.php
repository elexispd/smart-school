<?php

namespace App\Livewire\School;

use App\Models\{FeeStructure, FeeCategory, Session, SchoolClass, ClassArm};
use Livewire\Component;
use Livewire\WithPagination;

class ManageFeeStructures extends Component
{
    use WithPagination;

    public $search = '';
    public $viewMode = 'grid';
    public $showModal = false;
    public $showDeleteModal = false;
    public $structureId, $fee_category_id, $session_id, $term, $class_id, $class_arm_id, $amount, $payment_type = 'one_time', $is_active = true;
    public $installments = [];
    public $categories, $sessions, $classes, $classArms = [];
    public $is_general = true;
    public $isEdit = false;

    protected function rules()
    {
        return [
            'fee_category_id' => 'required|exists:fee_categories,id,school_id,' . auth()->user()->school_id,
            'session_id' => 'required|exists:academic_sessions,id,school_id,' . auth()->user()->school_id,
            'term' => 'nullable|in:first,second,third',
            'class_id' => 'nullable|exists:classes,id,school_id,' . auth()->user()->school_id,
            'class_arm_id' => 'nullable|exists:class_arms,id,school_id,' . auth()->user()->school_id,
            'amount' => 'required|numeric|min:0',
            'payment_type' => 'required|in:one_time,installment',
            'is_active' => 'boolean',
            'installments.*.name' => 'required_if:payment_type,installment|string',
            'installments.*.percentage' => 'required_if:payment_type,installment|numeric|min:0|max:100',
            'installments.*.due_date' => 'nullable|date',
        ];
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function create()
    {
        $schoolId = auth()->user()->school_id;
        $this->categories = FeeCategory::where('school_id', $schoolId)->where('is_active', true)->get();
        $this->sessions = Session::where('school_id', $schoolId)->get();
        $this->classes = SchoolClass::where('school_id', $schoolId)->where('is_active', true)->get();
        $this->reset(['fee_category_id', 'session_id', 'term', 'class_id', 'class_arm_id', 'amount', 'installments', 'structureId']);
        $this->payment_type = 'one_time';
        $this->is_active = true;
        $this->is_general = true;
        $this->isEdit = false;
        $this->showModal = true;
    }

    public function edit($id)
    {
        $schoolId = auth()->user()->school_id;
        $structure = FeeStructure::with('installments')->where('school_id', $schoolId)->findOrFail($id);
        
        $this->categories = FeeCategory::where('school_id', $schoolId)->where('is_active', true)->get();
        $this->sessions = Session::where('school_id', $schoolId)->get();
        $this->classes = SchoolClass::where('school_id', $schoolId)->where('is_active', true)->get();
        
        $this->structureId = $structure->id;
        $this->fee_category_id = $structure->fee_category_id;
        $this->session_id = $structure->session_id;
        $this->term = $structure->term;
        $this->class_id = $structure->class_id;
        $this->class_arm_id = $structure->class_arm_id;
        $this->amount = $structure->amount;
        $this->payment_type = $structure->payment_type;
        $this->is_active = $structure->is_active;
        $this->is_general = !$structure->class_id;
        $this->installments = $structure->installments->map(fn($i) => [
            'name' => $i->name,
            'percentage' => $i->percentage,
            'due_date' => $i->due_date?->format('Y-m-d'),
        ])->toArray();
        
        if ($this->class_id) {
            $this->classArms = ClassArm::where('class_id', $this->class_id)->where('is_active', true)->get();
        }
        
        $this->isEdit = true;
        $this->showModal = true;
    }

    public function updatedIsGeneral($value)
    {
        if ($value) {
            $this->class_id = null;
            $this->class_arm_id = null;
            $this->classArms = [];
        }
    }

    public function updatedClassId($value)
    {
        $this->classArms = $value ? ClassArm::where('class_id', $value)->where('is_active', true)->get() : [];
        if (!$this->classArms->contains('id', $this->class_arm_id)) $this->class_arm_id = null;
    }

    public function updatedPaymentType($value)
    {
        if ($value === 'installment' && empty($this->installments)) {
            $this->installments = [['name' => '', 'percentage' => '', 'due_date' => '']];
        }
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

        if ($this->payment_type === 'installment') {
            if (empty($this->installments)) {
                $this->addError('payment_type', 'Please add at least one installment.');
                return;
            }
            if (array_sum(array_column($this->installments, 'percentage')) != 100) {
                $this->addError('payment_type', 'Installment percentages must total 100%.');
                return;
            }
        }

        $data = [
            'school_id' => auth()->user()->school_id,
            'fee_category_id' => $this->fee_category_id,
            'session_id' => $this->session_id,
            'term' => $this->term,
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

        $this->closeModal();
        session()->flash('message', $this->structureId ? 'Fee structure updated successfully.' : 'Fee structure created successfully.');
    }

    public function delete($id)
    {
        $this->structureId = $id;
        $this->showDeleteModal = true;
    }

    public function confirmDelete()
    {
        $structure = FeeStructure::where('school_id', auth()->user()->school_id)->findOrFail($this->structureId);
        $structure->delete();
        $this->showDeleteModal = false;
        $this->reset(['structureId']);
        session()->flash('message', 'Fee structure deleted successfully.');
    }

    public function toggleStatus($id)
    {
        $structure = FeeStructure::where('school_id', auth()->user()->school_id)->findOrFail($id);
        $structure->update(['is_active' => !$structure->is_active]);
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->showDeleteModal = false;
        $this->reset(['fee_category_id', 'session_id', 'term', 'class_id', 'class_arm_id', 'amount', 'installments', 'structureId']);
        $this->payment_type = 'one_time';
        $this->is_active = true;
        $this->is_general = true;
    }

    private function isTermFutureOrCurrent($structureTerm, $currentTerm)
    {
        if (!$currentTerm) return true;
        $terms = ['first' => 1, 'second' => 2, 'third' => 3];
        return $terms[$structureTerm] >= $terms[$currentTerm];
    }

    public function render()
    {
        $currentSession = Session::where('school_id', auth()->user()->school_id)->where('is_current', true)->first();
        
        $structures = FeeStructure::with(['feeCategory', 'session', 'schoolClass', 'classArm'])
            ->where('school_id', auth()->user()->school_id)
            ->when($this->search, fn($q) => $q->whereHas('feeCategory', fn($q) => $q->where('name', 'like', '%' . $this->search . '%')))
            ->latest()
            ->paginate(10);
            
        foreach ($structures as $structure) {
            if (!$currentSession) {
                $structure->canModify = false;
                continue;
            }
            
            $isCurrentSession = $structure->session_id === $currentSession->id;
            
            if ($isCurrentSession) {
                if (!$structure->term || !$currentSession->current_term) {
                    $structure->canModify = true;
                } else {
                    $structure->canModify = $this->isTermFutureOrCurrent($structure->term, $currentSession->current_term);
                }
            } else {
                $structure->canModify = false;
            }
        }
        
        return view('livewire.school.manage-fee-structures', compact('structures'))
            ->layout('layouts.app')
            ->title('Fee Structures');
    }
}
