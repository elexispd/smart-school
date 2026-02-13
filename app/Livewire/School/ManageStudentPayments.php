<?php

namespace App\Livewire\School;

use App\Models\{StudentPayment, Student, FeeStructure, Session, SchoolClass, ClassArm};
use App\Exports\PaymentReportExport;
use Maatwebsite\Excel\Facades\Excel;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;

class ManageStudentPayments extends Component
{
    use WithPagination;

    public $search = '';
    public $filterClass = '';
    public $filterClassArm = '';
    public $filterPaymentStatus = '';
    public $filterFeeStructure = '';
    public $filterDateFrom = '';
    public $filterDateTo = '';
    public $showModal = false;
    public $showDeleteModal = false;
    public $showStudentSearchModal = false;
    public $showFilterModal = false;
    public $studentSearch = '';
    public $searchResults = [];
    public $paymentId, $student_id, $fee_structure_id, $fee_installment_id, $amount, $payment_method = 'cash', $reference_number, $payment_date, $remarks;
    public $feeStructures = [], $installments = [];
    public $selectedStudentInfo;
    public $selectedFeeStructure;
    public $totalPaid = 0;
    public $remainingBalance = 0;
    
    public $reportFeeStructure = '';
    public $reportClass = '';
    public $reportClassArm = '';
    public $reportStatus = '';
    public $reportDateFrom = '';
    public $reportDateTo = '';

    protected function rules()
    {
        $rules = [
            'student_id' => 'required|exists:students,id,school_id,' . auth()->user()->school_id,
            'fee_structure_id' => 'required|exists:fee_structures,id,school_id,' . auth()->user()->school_id,
            'fee_installment_id' => 'nullable|exists:fee_installments,id',
            'payment_method' => 'required|in:cash,bank_transfer,card,cheque,online',
            'reference_number' => 'nullable|string',
            'payment_date' => 'required|date',
            'remarks' => 'nullable|string',
        ];

        if ($this->selectedFeeStructure && $this->selectedFeeStructure->payment_type === 'installment') {
            $rules['fee_installment_id'] = 'required|exists:fee_installments,id';
            $rules['amount'] = 'required|numeric|min:0';
        } else {
            $rules['amount'] = 'required|numeric|in:' . ($this->selectedFeeStructure ? $this->selectedFeeStructure->amount : 0);
        }

        return $rules;
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatedFilterClass()
    {
        $this->filterClassArm = '';
        $this->resetPage();
    }

    public function updatedStudentSearch()
    {
        if (strlen($this->studentSearch) >= 2) {
            $this->searchResults = Student::with(['user', 'currentClass', 'classArm'])
                ->where('school_id', auth()->user()->school_id)
                ->where('status', 'active')
                ->where(function($q) {
                    $q->where('admission_number', 'like', '%' . $this->studentSearch . '%')
                      ->orWhereHas('user', fn($query) => $query->where('name', 'like', '%' . $this->studentSearch . '%'));
                })
                ->limit(10)
                ->get();
        } else {
            $this->searchResults = [];
        }
    }

    public function selectStudent($studentId)
    {
        $this->student_id = $studentId;
        $student = Student::with(['user', 'currentClass', 'classArm'])->find($studentId);
        $this->selectedStudentInfo = $student;
        $currentSession = Session::where('school_id', auth()->user()->school_id)->where('is_current', true)->first();
        
        $this->feeStructures = FeeStructure::with(['feeCategory', 'installments', 'session'])
            ->where('school_id', auth()->user()->school_id)
            ->where('session_id', $currentSession->id)
            ->where('is_active', true)
            ->where(function($q) use ($student) {
                $q->whereNull('class_id')
                  ->orWhere('class_id', $student->current_class_id);
            })
            ->get();
        
        $this->showStudentSearchModal = false;
        $this->showModal = true;
    }

    public function updatedFeeStructureId($value)
    {
        if ($value) {
            $structure = FeeStructure::with('installments')->find($value);
            $this->selectedFeeStructure = $structure;
            $this->installments = $structure->installments ?? [];
            
            $this->totalPaid = StudentPayment::where('student_id', $this->student_id)
                ->where('fee_structure_id', $value)
                ->sum('amount');
            
            $this->remainingBalance = $structure->amount - $this->totalPaid;
            
            if ($structure->payment_type === 'installment') {
                $paidInstallmentIds = StudentPayment::where('student_id', $this->student_id)
                    ->where('fee_structure_id', $value)
                    ->whereNotNull('fee_installment_id')
                    ->pluck('fee_installment_id')
                    ->toArray();
                
                $this->installments = $structure->installments->filter(function($inst) use ($paidInstallmentIds) {
                    return !in_array($inst->id, $paidInstallmentIds);
                });
                
                $this->amount = null;
            } else {
                $this->amount = $structure->amount;
            }
            
            $this->fee_installment_id = null;
        }
    }

    public function updatedFeeInstallmentId($value)
    {
        if ($value && $this->fee_structure_id) {
            $structure = FeeStructure::find($this->fee_structure_id);
            $installment = $structure->installments()->find($value);
            if ($installment) {
                $this->amount = ($structure->amount * $installment->percentage) / 100;
            }
        }
    }

    public function create()
    {
        $this->reset(['paymentId', 'student_id', 'fee_structure_id', 'fee_installment_id', 'amount', 'reference_number', 'remarks', 'feeStructures', 'installments', 'studentSearch', 'searchResults', 'selectedStudentInfo', 'selectedFeeStructure', 'totalPaid', 'remainingBalance']);
        $this->payment_method = 'cash';
        $this->payment_date = now()->format('Y-m-d');
        $this->showStudentSearchModal = true;
    }

    public function save()
    {
        $this->validate();

        StudentPayment::create([
            'school_id' => auth()->user()->school_id,
            'student_id' => $this->student_id,
            'fee_structure_id' => $this->fee_structure_id,
            'fee_installment_id' => $this->fee_installment_id,
            'amount' => $this->amount,
            'payment_method' => $this->payment_method,
            'reference_number' => $this->reference_number,
            'payment_date' => $this->payment_date,
            'remarks' => $this->remarks,
            'recorded_by' => auth()->id(),
        ]);

        $this->closeModal();
        session()->flash('message', 'Payment recorded successfully.');
    }

    public function delete($id)
    {
        $this->paymentId = $id;
        $this->showDeleteModal = true;
    }

    public function confirmDelete()
    {
        StudentPayment::where('school_id', auth()->user()->school_id)->findOrFail($this->paymentId)->delete();
        $this->showDeleteModal = false;
        $this->reset(['paymentId']);
        session()->flash('message', 'Payment deleted successfully.');
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->showDeleteModal = false;
        $this->showStudentSearchModal = false;
        $this->showFilterModal = false;
        $this->reset(['paymentId', 'student_id', 'fee_structure_id', 'fee_installment_id', 'amount', 'reference_number', 'remarks', 'feeStructures', 'installments', 'studentSearch', 'searchResults', 'selectedStudentInfo', 'selectedFeeStructure', 'totalPaid', 'remainingBalance']);
    }

    public function openFilterModal()
    {
        $this->showFilterModal = true;
    }

    public function applyFilters()
    {
        $this->filterFeeStructure = $this->reportFeeStructure;
        $this->filterClass = $this->reportClass;
        $this->filterClassArm = $this->reportClassArm;
        $this->filterPaymentStatus = $this->reportStatus;
        $this->filterDateFrom = $this->reportDateFrom;
        $this->filterDateTo = $this->reportDateTo;
        $this->showFilterModal = false;
        $this->resetPage();
    }

    public function clearFilters()
    {
        $this->reset(['reportFeeStructure', 'reportClass', 'reportClassArm', 'reportStatus', 'reportDateFrom', 'reportDateTo', 'filterClass', 'filterClassArm', 'filterPaymentStatus', 'filterFeeStructure', 'filterDateFrom', 'filterDateTo']);
        $this->resetPage();
    }

    public function exportReport()
    {
        $data = $this->getReportData();
        return Excel::download(new PaymentReportExport($data), 'payment-report-' . now()->format('Y-m-d') . '.xlsx');
    }

    private function getReportData()
    {
        $schoolId = auth()->user()->school_id;
        $currentSession = Session::where('school_id', $schoolId)->where('is_current', true)->first();
        
        $query = Student::with(['user', 'currentClass', 'classArm'])
            ->where('school_id', $schoolId)
            ->where('status', 'active');

        if ($this->reportClass) {
            $query->where('current_class_id', $this->reportClass);
        }
        if ($this->reportClassArm) {
            $query->where('class_arm_id', $this->reportClassArm);
        }

        $students = $query->get();
        $feeStructureId = $this->reportFeeStructure;

        return $students->map(function($student) use ($feeStructureId, $currentSession, $schoolId) {
            $feeQuery = FeeStructure::with('feeCategory')
                ->where('school_id', $schoolId)
                ->where('session_id', $currentSession->id)
                ->where('is_active', true)
                ->where(function($q) use ($student) {
                    $q->whereNull('class_id')->orWhere('class_id', $student->current_class_id);
                });

            if ($feeStructureId) {
                $feeQuery->where('id', $feeStructureId);
            }

            $feeStructures = $feeQuery->get();

            return $feeStructures->map(function($fee) use ($student) {
                $paymentsQuery = StudentPayment::where('student_id', $student->id)
                    ->where('fee_structure_id', $fee->id);

                if ($this->reportDateFrom) {
                    $paymentsQuery->whereDate('payment_date', '>=', $this->reportDateFrom);
                }
                if ($this->reportDateTo) {
                    $paymentsQuery->whereDate('payment_date', '<=', $this->reportDateTo);
                }

                $totalPaid = $paymentsQuery->sum('amount');
                $balance = $fee->amount - $totalPaid;
                $status = $totalPaid == 0 ? 'Unpaid' : ($balance > 0 ? 'Partial' : 'Paid');

                if ($this->reportStatus && $this->reportStatus !== $status) {
                    return null;
                }

                return (object) [
                    'student_name' => $student->user->name,
                    'admission_number' => $student->admission_number,
                    'class_name' => $student->currentClass->name . ($student->classArm ? ' - ' . $student->classArm->name : ''),
                    'fee_category' => $fee->feeCategory->name,
                    'total_fee' => $fee->amount,
                    'amount_paid' => $totalPaid,
                    'balance' => $balance,
                    'status' => $status,
                    'last_payment_date' => $paymentsQuery->latest('payment_date')->first()?->payment_date,
                ];
            })->filter();
        })->flatten()->filter();
    }

    public function render()
    {
        $currentSession = Session::where('school_id', auth()->user()->school_id)->where('is_current', true)->first();
        
        if ($this->filterPaymentStatus) {
            $reportData = $this->getReportData();
            $payments = new \Illuminate\Pagination\LengthAwarePaginator(
                $reportData->forPage(request()->get('page', 1), 15),
                $reportData->count(),
                15,
                request()->get('page', 1),
                ['path' => request()->url()]
            );
        } else {
            $payments = StudentPayment::with(['student.user', 'student.currentClass', 'student.classArm', 'feeStructure.feeCategory', 'feeStructure.session', 'feeInstallment', 'recordedBy'])
                ->where('school_id', auth()->user()->school_id)
                ->when($this->search, fn($q) => $q->whereHas('student', function($query) {
                    $query->where('admission_number', 'like', '%' . $this->search . '%')
                          ->orWhereHas('user', fn($q) => $q->where('name', 'like', '%' . $this->search . '%'));
                }))
                ->when($this->filterFeeStructure, fn($q) => $q->where('fee_structure_id', $this->filterFeeStructure))
                ->when($this->filterClass, fn($q) => $q->whereHas('student', fn($query) => $query->where('current_class_id', $this->filterClass)))
                ->when($this->filterClassArm, fn($q) => $q->whereHas('student', fn($query) => $query->where('class_arm_id', $this->filterClassArm)))
                ->when($this->filterDateFrom, fn($q) => $q->whereDate('payment_date', '>=', $this->filterDateFrom))
                ->when($this->filterDateTo, fn($q) => $q->whereDate('payment_date', '<=', $this->filterDateTo))
                ->latest()
                ->paginate(15);
        }

        $classes = SchoolClass::where('school_id', auth()->user()->school_id)->where('is_active', true)->get();
        $classArms = $this->filterClass ? ClassArm::where('class_id', $this->filterClass)->where('is_active', true)->get() : collect();
        $reportClassArms = $this->reportClass ? ClassArm::where('class_id', $this->reportClass)->where('is_active', true)->get() : collect();
        $allFeeStructures = FeeStructure::with('feeCategory')->where('school_id', auth()->user()->school_id)->where('session_id', $currentSession->id)->where('is_active', true)->get();

        $stats = [
            'total_collected' => StudentPayment::where('school_id', auth()->user()->school_id)->sum('amount'),
            'today_collected' => StudentPayment::where('school_id', auth()->user()->school_id)->whereDate('payment_date', today())->sum('amount'),
            'total_payments' => StudentPayment::where('school_id', auth()->user()->school_id)->count(),
        ];

        return view('livewire.school.manage-student-payments', compact('payments', 'classes', 'classArms', 'reportClassArms', 'allFeeStructures', 'stats', 'currentSession'))
            ->layout('layouts.app')
            ->title('Student Payments');
    }
}
