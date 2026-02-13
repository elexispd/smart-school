<?php

namespace App\Livewire\School;

use App\Models\User;
use App\Models\Student;
use App\Models\Staff;
use App\Models\SchoolClass;
use App\Models\ClassArm;
use App\Imports\StudentsImport;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class ManageUsers extends Component
{
    use WithPagination, WithFileUploads;

    public $search = '';
    public $viewMode = 'grid';
    public $filterRole = '';
    public $filterClass = '';
    public $filterClassArm = '';
    public $showModal = false;
    public $showDeleteModal = false;
    public $showViewModal = false;
    public $showImportModal = false;
    public $showSubjectsModal = false;
    public $staffSubjects = [];
    public $importFile;
    public $importClassId;
    public $importClassArmId;
    public $userId;
    
    // User fields
    public $name, $email, $password, $role;
    
    // Student/Staff fields
    public $admission_number, $staff_id, $current_class_id, $class_arm_id;
    public $date_of_birth, $gender, $blood_group, $address;
    public $guardian_name, $guardian_phone, $guardian_email, $guardian_relationship;
    public $emergency_contact, $medical_conditions, $previous_school, $admission_date;
    public $status = 'active';

    public function updatedImportClassId($value)
    {
        $this->importClassArmId = null;
    }

    public function updatedCurrentClassId($value)
    {
        $this->class_arm_id = null;
    }

    public function updatedFilterClass($value)
    {
        $this->filterClassArm = '';
        $this->resetPage();
    }

    public function updatedFilterClassArm()
    {
        $this->resetPage();
    }

    protected function rules()
    {
        $rules = [
            'name' => 'required|min:3',
            'status' => 'required|in:active,inactive',
        ];

        if ($this->role === 'student') {
            $rules['admission_number'] = 'required|unique:students,admission_number,' . ($this->userId ? Student::where('user_id', $this->userId)->value('id') : 'NULL') . ',id,school_id,' . auth()->user()->school_id;
            $rules['current_class_id'] = 'required|exists:classes,id';
            $rules['class_arm_id'] = 'required|exists:class_arms,id';
        } elseif ($this->role === 'staff') {
            $rules['email'] = 'required|email|unique:users,email,' . $this->userId;
            $rules['staff_id'] = 'nullable|unique:staff,staff_id,' . ($this->userId ? Staff::where('user_id', $this->userId)->value('id') : 'NULL') . ',id,school_id,' . auth()->user()->school_id;
            if (!$this->userId) {
                $rules['password'] = 'required|min:8';
            } else {
                $rules['password'] = 'nullable|min:8';
            }
        }

        if (!$this->userId) {
            $rules['role'] = 'required|in:student,staff';
        }

        return $rules;
    }

    public function mount()
    {
        if (request('filter')) {
            $this->filterRole = request('filter');
        }
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingFilterRole()
    {
        $this->resetPage();
    }

    public function exportCsv()
    {
        $users = $this->getFilteredUsers();
        
        $filename = 'users_' . date('Y-m-d_His') . '.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($users) {
            $file = fopen('php://output', 'w');
            
            // Check if filtering students or staff
            $hasStudents = $users->contains(fn($u) => $u->role === 'student');
            $hasStaff = $users->contains(fn($u) => $u->role === 'staff');
            
            if ($hasStaff && !$hasStudents) {
                // Staff only
                fputcsv($file, ['S/N', 'Name', 'Staff Number', 'Gender']);
                foreach ($users as $index => $user) {
                    fputcsv($file, [
                        $index + 1,
                        $user->name,
                        $user->staff?->staff_id ?? 'N/A',
                        $user->staff?->gender ? ucfirst($user->staff->gender) : 'N/A',
                    ]);
                }
            } else {
                // Students or mixed
                fputcsv($file, ['S/N', 'Name', 'Admission Number', 'Class', 'Class Arm']);
                foreach ($users as $index => $user) {
                    fputcsv($file, [
                        $index + 1,
                        $user->name,
                        $user->student?->admission_number ?? ($user->staff?->staff_id ?? 'N/A'),
                        $user->student?->currentClass?->name ?? 'N/A',
                        $user->student?->classArm?->name ?? 'N/A',
                    ]);
                }
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function exportPdf()
    {
        $users = $this->getFilteredUsers();
        return response()->streamDownload(function() use ($users) {
            echo view('livewire.school.users-pdf', compact('users'))->render();
        }, 'users_' . date('Y-m-d_His') . '.pdf', ['Content-Type' => 'application/pdf']);
    }

    private function getFilteredUsers()
    {
        return User::query()
            ->whereIn('role', ['student', 'staff'])
            ->with(['student.currentClass', 'student.classArm', 'staff'])
            ->when($this->search, fn($q) => $q->where(function($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('email', 'like', '%' . $this->search . '%');
            }))
            ->when($this->filterRole, fn($q) => $q->where('role', $this->filterRole))
            ->when($this->filterClass, function($q) {
                $q->whereHas('student', fn($query) => $query->where('current_class_id', $this->filterClass));
            })
            ->when($this->filterClassArm, function($q) {
                $q->whereHas('student', fn($query) => $query->where('class_arm_id', $this->filterClassArm));
            })
            ->latest()
            ->get();
    }

    public function create()
    {
        if (auth()->user()->role !== 'school_admin') abort(403);
        
        $this->reset(['name', 'email', 'password', 'userId', 'admission_number', 'staff_id', 
            'current_class_id', 'class_arm_id', 'date_of_birth', 'gender', 'blood_group', 'address',
            'guardian_name', 'guardian_phone', 'guardian_email', 'guardian_relationship',
            'emergency_contact', 'medical_conditions', 'previous_school', 'admission_date']);
        $this->role = $this->filterRole ?: '';
        $this->status = 'active';
        $this->showModal = true;
    }

    public function view($id)
    {
        if (auth()->user()->role !== 'school_admin') abort(403);
        
        $user = User::with(['student.currentClass', 'student.classArm', 'staff'])->findOrFail($id);
        $this->userId = $id;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->role = $user->role;

        if ($user->student) {
            $this->admission_number = $user->student->admission_number;
            $this->current_class_id = $user->student->current_class_id;
            $this->class_arm_id = $user->student->class_arm_id;
            $this->date_of_birth = $user->student->date_of_birth?->format('Y-m-d');
            $this->gender = $user->student->gender;
            $this->blood_group = $user->student->blood_group;
            $this->address = $user->student->address;
            $this->guardian_name = $user->student->guardian_name;
            $this->guardian_phone = $user->student->guardian_phone;
            $this->guardian_email = $user->student->guardian_email;
            $this->guardian_relationship = $user->student->guardian_relationship;
            $this->emergency_contact = $user->student->emergency_contact;
            $this->medical_conditions = $user->student->medical_conditions;
            $this->previous_school = $user->student->previous_school;
            $this->admission_date = $user->student->admission_date?->format('Y-m-d');
            $this->status = $user->student->status;
        } elseif ($user->staff) {
            $this->staff_id = $user->staff->staff_id;
            $this->date_of_birth = $user->staff->date_of_birth?->format('Y-m-d');
            $this->gender = $user->staff->gender;
            $this->blood_group = $user->staff->blood_group;
            $this->address = $user->staff->address;
            $this->guardian_name = $user->staff->guardian_name;
            $this->guardian_phone = $user->staff->guardian_phone;
            $this->guardian_email = $user->staff->guardian_email;
            $this->guardian_relationship = $user->staff->guardian_relationship;
            $this->emergency_contact = $user->staff->emergency_contact;
            $this->medical_conditions = $user->staff->medical_conditions;
            $this->admission_date = $user->staff->admission_date?->format('Y-m-d');
            $this->status = $user->staff->status;
        }

        $this->showModal = false;
        $this->showDeleteModal = false;
        $this->showViewModal = true;
    }

    public function edit($id)
    {
        if (auth()->user()->role !== 'school_admin') abort(403);
        
        $user = User::with(['student', 'staff'])->findOrFail($id);
        $this->userId = $id;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->role = $user->role;

        if ($user->student) {
            $this->admission_number = $user->student->admission_number;
            $this->current_class_id = $user->student->current_class_id;
            $this->class_arm_id = $user->student->class_arm_id;
            $this->date_of_birth = $user->student->date_of_birth?->format('Y-m-d');
            $this->gender = $user->student->gender;
            $this->blood_group = $user->student->blood_group;
            $this->address = $user->student->address;
            $this->guardian_name = $user->student->guardian_name;
            $this->guardian_phone = $user->student->guardian_phone;
            $this->guardian_email = $user->student->guardian_email;
            $this->guardian_relationship = $user->student->guardian_relationship;
            $this->emergency_contact = $user->student->emergency_contact;
            $this->medical_conditions = $user->student->medical_conditions;
            $this->previous_school = $user->student->previous_school;
            $this->admission_date = $user->student->admission_date?->format('Y-m-d');
            $this->status = $user->student->status;
        } elseif ($user->staff) {
            $this->staff_id = $user->staff->staff_id;
            $this->date_of_birth = $user->staff->date_of_birth?->format('Y-m-d');
            $this->gender = $user->staff->gender;
            $this->blood_group = $user->staff->blood_group;
            $this->address = $user->staff->address;
            $this->guardian_name = $user->staff->guardian_name;
            $this->guardian_phone = $user->staff->guardian_phone;
            $this->guardian_email = $user->staff->guardian_email;
            $this->guardian_relationship = $user->staff->guardian_relationship;
            $this->emergency_contact = $user->staff->emergency_contact;
            $this->medical_conditions = $user->staff->medical_conditions;
            $this->admission_date = $user->staff->admission_date?->format('Y-m-d');
            $this->status = $user->staff->status;
        }

        $this->showModal = true;
    }

    public function save()
    {
        if (auth()->user()->role !== 'school_admin') abort(403);
        
        $this->validate();

        DB::transaction(function () {
            $school = auth()->user()->school;
            
            // Generate unique email for students
            if ($this->role === 'student') {
                $firstName = strtolower(explode(' ', $this->name)[0]);
                $schoolAcronym = strtolower($school->acronym ?? 'school');
                
                $email = $firstName . '@' . $schoolAcronym . '.com';
                $counter = 2;
                
                while (User::where('email', $email)->when($this->userId, fn($q) => $q->where('id', '!=', $this->userId))->exists()) {
                    $email = $firstName . $counter . '@' . $schoolAcronym . '.com';
                    $counter++;
                }
            }
            
            $userData = [
                'name' => $this->name,
                'email' => $this->role === 'student' ? $email : $this->email,
                'role' => $this->role,
                'school_id' => auth()->user()->school_id,
            ];

            if ($this->role === 'student' && !$this->userId) {
                $userData['password'] = Hash::make('password');
            } elseif ($this->password) {
                $userData['password'] = Hash::make($this->password);
            }

            if ($this->userId) {
                $user = User::findOrFail($this->userId);
                $user->update($userData);
            } else {
                $user = User::create($userData);
            }

            $profileData = [
                'school_id' => auth()->user()->school_id,
                'date_of_birth' => $this->date_of_birth,
                'gender' => $this->gender,
                'blood_group' => $this->blood_group,
                'address' => $this->address,
                'guardian_name' => $this->guardian_name,
                'guardian_phone' => $this->guardian_phone,
                'guardian_email' => $this->guardian_email,
                'guardian_relationship' => $this->guardian_relationship,
                'emergency_contact' => $this->emergency_contact,
                'medical_conditions' => $this->medical_conditions,
                'admission_date' => $this->admission_date,
                'status' => $this->status,
            ];

            if ($this->role === 'student') {
                $profileData['admission_number'] = $this->admission_number;
                $profileData['current_class_id'] = $this->current_class_id;
                $profileData['class_arm_id'] = $this->class_arm_id;
                
                $student = Student::updateOrCreate(['user_id' => $user->id], $profileData);
                
                if (!$student->r_pin) {
                    $student->update(['r_pin' => str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT)]);
                }
                
                Staff::where('user_id', $user->id)->delete();
            } elseif ($this->role === 'staff') {
                $profileData['staff_id'] = $this->staff_id;
                
                Staff::updateOrCreate(['user_id' => $user->id], $profileData);
                Student::where('user_id', $user->id)->delete();
            }
        });

        $this->closeModal();
    }

    public function delete($id)
    {
        if (auth()->user()->role !== 'school_admin') abort(403);
        
        $this->userId = $id;
        $this->showDeleteModal = true;
    }

    public function confirmDelete()
    {
        if (auth()->user()->role !== 'school_admin') abort(403);
        
        User::findOrFail($this->userId)->delete();
        $this->showDeleteModal = false;
        $this->reset(['userId']);
    }

    public function toggleStatus($id)
    {
        if (auth()->user()->role !== 'school_admin') abort(403);
        
        $user = User::with(['student', 'staff'])->findOrFail($id);
        
        if ($user->student) {
            $user->student->update(['status' => $user->student->status === 'active' ? 'inactive' : 'active']);
        } elseif ($user->staff) {
            $user->staff->update(['status' => $user->staff->status === 'active' ? 'inactive' : 'active']);
        }
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->showDeleteModal = false;
        $this->showViewModal = false;
        $this->showImportModal = false;
        $this->showSubjectsModal = false;
        $this->reset(['name', 'email', 'password', 'role', 'userId', 'admission_number', 'staff_id',
            'current_class_id', 'class_arm_id', 'date_of_birth', 'gender', 'blood_group', 'address',
            'guardian_name', 'guardian_phone', 'guardian_email', 'guardian_relationship',
            'emergency_contact', 'medical_conditions', 'previous_school', 'admission_date', 'importFile',
            'importClassId', 'importClassArmId', 'staffSubjects']);
        $this->status = 'active';
    }

    public function viewStaffSubjects($userId)
    {
        $staff = \App\Models\Staff::where('user_id', $userId)->first();
        if (!$staff) return;

        $currentSession = \App\Models\Session::where('is_current', true)->first();
        if (!$currentSession) return;

        $this->staffSubjects = \App\Models\StaffSubjectAssignment::with(['subject', 'schoolClass', 'classArm'])
            ->where('staff_id', $staff->id)
            ->where('session_id', $currentSession->id)
            ->where('term', ucfirst($currentSession->current_term) . ' Term')
            ->get()
            ->map(fn($item) => [
                'subject' => $item->subject->name,
                'class' => $item->schoolClass->name . ' - ' . $item->classArm->name,
            ])
            ->toArray();

        $this->showSubjectsModal = true;
    }

    public function openImportModal()
    {
        if (auth()->user()->role !== 'school_admin') abort(403);
        $this->showImportModal = true;
    }

    public function importStudents()
    {
        if (auth()->user()->role !== 'school_admin') abort(403);
        
        $this->validate([
            'importFile' => 'required|mimes:xlsx,xls,csv|max:2048',
            'importClassId' => 'required|exists:classes,id',
            'importClassArmId' => 'required|exists:class_arms,id',
        ]);

        try {
            Excel::import(
                new StudentsImport(auth()->user()->school_id, auth()->user()->school->acronym, $this->importClassId, $this->importClassArmId),
                $this->importFile
            );
            
            session()->flash('message', 'Students imported successfully!');
            $this->closeModal();
        } catch (\Exception $e) {
            session()->flash('error', 'Import failed: ' . $e->getMessage());
        }
    }

    public function render()
    {
        $users = User::query()
            ->whereIn('role', ['student', 'staff'])
            ->with(['student.currentClass', 'student.classArm', 'staff'])
            ->when($this->search, fn($q) => $q->where(function($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('email', 'like', '%' . $this->search . '%');
            }))
            ->when($this->filterRole, fn($q) => $q->where('role', $this->filterRole))
            ->when($this->filterClass, function($q) {
                $q->whereHas('student', fn($query) => $query->where('current_class_id', $this->filterClass));
            })
            ->when($this->filterClassArm, function($q) {
                $q->whereHas('student', fn($query) => $query->where('class_arm_id', $this->filterClassArm));
            })
            ->latest()
            ->paginate(12);

        $classes = SchoolClass::where('is_active', true)->get();
        $classArms = $this->current_class_id 
            ? ClassArm::where('class_id', $this->current_class_id)->where('is_active', true)->get()
            : ClassArm::where('is_active', true)->get();
        
        $filterClassArms = $this->filterClass
            ? ClassArm::where('class_id', $this->filterClass)->where('is_active', true)->get()
            : collect();

        return view('livewire.school.manage-users', compact('users', 'classes', 'classArms', 'filterClassArms'))
            ->layout('layouts.app')
            ->title('Manage Users');
    }
}
