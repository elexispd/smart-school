<?php

namespace App\Livewire;

use App\Models\School;
use App\Models\User;
use App\Notifications\SchoolRequestStatusUpdated;
use App\Notifications\SchoolStatusChanged;
use Illuminate\Support\Facades\Notification;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Rule;

class SchoolList extends Component
{
    use WithPagination;

    public $search = '';

    // Modal States
    public $showDetailsModal = false;
    public $showEditModal = false;
    public $showDeleteModal = false;
    public $showApproveModal = false;
    public $showRejectModal = false;
    
    public $selectedSchoolId;
    public $schoolToDeleteId;
    public $schoolToApproveId;
    public $schoolToRejectId;
    public $rejectionReason = '';

    // Edit Form Fields
    #[Rule('required|min:3')]
    public $name;
    
    #[Rule('nullable|string')]
    public $acronym;
    
    #[Rule('nullable|email')]
    public $email;
    
    #[Rule('nullable|string')]
    public $phone;
    
    #[Rule('nullable|string')]
    public $moto;
    
    #[Rule('required|string')]
    public $address;
    
    #[Rule('required|string')]
    public $city;
    
    #[Rule('required|string')]
    public $state;
    
    #[Rule('required|string')]
    public $country;
    
    #[Rule('boolean')]
    public $is_active = true;

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function viewSchool($id)
    {
        $this->selectedSchoolId = $id;
        $this->showDetailsModal = true;
    }

    public function editSchool($id)
    {
        if (!auth()->user()->hasPermission('edit schools')) {
            abort(403);
        }
        
        $school = School::findOrFail($id);
        $this->selectedSchoolId = $id;
        $this->name = $school->name;
        $this->acronym = $school->acronym;
        $this->email = $school->email;
        $this->phone = $school->phone;
        $this->moto = $school->moto;
        $this->address = $school->address;
        $this->city = $school->city;
        $this->state = $school->state;
        $this->country = $school->country;
        $this->is_active = (bool) $school->is_active;
        
        $this->showEditModal = true;
    }

    public function updateSchool()
    {
        if (!auth()->user()->hasPermission('edit schools')) {
            abort(403);
        }
        
        $this->validate();

        $school = School::findOrFail($this->selectedSchoolId);
        $oldIsActive = $school->is_active;
        
        $school->update([
            'name' => $this->name,
            'acronym' => $this->acronym,
            'email' => $this->email,
            'phone' => $this->phone,
            'moto' => $this->moto,
            'address' => $this->address,
            'city' => $this->city,
            'state' => $this->state,
            'country' => $this->country,
            'is_active' => $this->is_active,
        ]);

        // Send email if status changed
        if ($oldIsActive != $this->is_active) {
            $admin = User::where('school_id', $school->id)->where('role', 'school_admin')->first();
            if ($admin) {
                Notification::route('mail', $admin->email)
                    ->notify(new SchoolStatusChanged($school, $this->is_active, $admin->name, $admin->email));
            }
        }

        $this->showEditModal = false;
        $this->reset(['name', 'acronym', 'email', 'phone', 'moto', 'address', 'city', 'state', 'country', 'selectedSchoolId']);
    }

    public function approveSchool($id)
    {
        $this->schoolToApproveId = $id;
        $this->showApproveModal = true;
    }

    public function confirmApprove()
    {
        $school = School::findOrFail($this->schoolToApproveId);
        $school->update(['status' => 'approved', 'is_active' => true, 'approved_by' => auth()->id(), 'approved_at' => now()]);

        // Get admin user
        $admin = User::where('school_id', $school->id)->where('role', 'school_admin')->first();
        if ($admin) {
            Notification::route('mail', $admin->email)
                ->notify(new SchoolRequestStatusUpdated($school, 'approved', $admin->name, $admin->email));
        }

        $this->showApproveModal = false;
        $this->reset(['schoolToApproveId']);
    }

    public function rejectSchool($id)
    {
        $this->schoolToRejectId = $id;
        $this->showRejectModal = true;
    }

    public function confirmReject()
    {
        $school = School::findOrFail($this->schoolToRejectId);
        $school->update(['status' => 'rejected', 'is_active' => false]);

        // Get admin user
        $admin = User::where('school_id', $school->id)->where('role', 'school_admin')->first();
        if ($admin) {
            Notification::route('mail', $admin->email)
                ->notify(new SchoolRequestStatusUpdated($school, 'rejected', $admin->name, $admin->email, $this->rejectionReason));
        }

        $this->showRejectModal = false;
        $this->reset(['schoolToRejectId', 'rejectionReason']);
    }

    public function deleteSchool($id)
    {
        if (!auth()->user()->hasPermission('delete schools')) {
            abort(403);
        }
        
        $this->schoolToDeleteId = $id;
        $this->showDeleteModal = true;
    }

    public function confirmDelete()
    {
        if (!auth()->user()->hasPermission('delete schools')) {
            abort(403);
        }
        
        if ($this->schoolToDeleteId) {
            School::findOrFail($this->schoolToDeleteId)->delete();
        }
        $this->showDeleteModal = false;
        $this->reset(['schoolToDeleteId']);
        $this->resetPage();
    }
    
    public function closeModal()
    {
        $this->showDetailsModal = false;
        $this->showEditModal = false;
        $this->showDeleteModal = false;
        $this->showApproveModal = false;
        $this->showRejectModal = false;
        $this->reset(['name', 'acronym', 'email', 'phone', 'moto', 'address', 'city', 'state', 'country', 'selectedSchoolId', 'schoolToDeleteId', 'schoolToApproveId', 'schoolToRejectId', 'rejectionReason']);
    }

    public function render()
    {
        $schools = School::query()
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('city', 'like', '%' . $this->search . '%')
                    ->orWhere('state', 'like', '%' . $this->search . '%')
                    ->orWhere('country', 'like', '%' . $this->search . '%');
            })
            ->latest()
            ->paginate(10);
            
        $selectedSchool = $this->selectedSchoolId ? School::find($this->selectedSchoolId) : null;

        return view('livewire.platform.schools.school-list', compact('schools', 'selectedSchool'))
            ->layout('layouts.app')
            ->title('Schools');
    }
}
