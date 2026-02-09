<?php

namespace App\Livewire;

use App\Models\User;
use App\Models\School;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Hash;

class SuperAdminUsers extends Component
{
    use WithPagination;

    public $search = '';
    public $roleFilter = '';
    public $userType = 'school';
    public $viewMode = 'grid';
    public $showAddModal = false;
    public $showAddSaasAdminModal = false;
    public $showEditModal = false;
    public $showDeleteModal = false;
    public $showViewModal = false;
    
    public $userId;
    public $viewUserId;
    public $name;
    public $email;
    public $password;
    public $role = 'student';
    public $school_id;

    protected $rules = [
        'name' => 'required|min:3',
        'email' => 'required|email',
        'role' => 'required',
        'school_id' => 'nullable',
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function addUser()
    {
        $this->reset(['name', 'email', 'password', 'role', 'school_id', 'userId']);
        $this->role = 'student';
        $this->showAddModal = true;
    }

    public function viewUser($id)
    {
        $this->viewUserId = $id;
        $this->showViewModal = true;
    }

    public function addSaasAdmin()
    {
        $this->reset(['name', 'email', 'password', 'role', 'school_id', 'userId']);
        $this->role = 'admin';
        $this->showAddSaasAdminModal = true;
    }

    public function saveUser()
    {
        if (!auth()->user()->hasPermission('create users')) {
            abort(403);
        }
        
        $this->validate([
            'name' => 'required|min:3',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8',
            'role' => 'required',
            'school_id' => 'nullable',
        ]);

        User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
            'role' => $this->role,
            'school_id' => $this->school_id,
        ]);

        $this->showAddModal = false;
        $this->reset(['name', 'email', 'password', 'role', 'school_id']);
    }

    public function saveSaasAdmin()
    {
        if (!auth()->user()->hasPermission('create users')) {
            abort(403);
        }
        
        $this->validate([
            'name' => 'required|min:3',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8',
        ]);

        User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
            'role' => 'admin',
            'school_id' => null,
        ]);

        $this->showAddSaasAdminModal = false;
        $this->reset(['name', 'email', 'password']);
    }

    public function editUser($id)
    {
        if (!auth()->user()->hasPermission('edit users')) {
            abort(403);
        }
        
        $user = User::findOrFail($id);
        $this->userId = $id;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->role = $user->role;
        $this->school_id = $user->school_id;
        $this->showEditModal = true;
    }

    public function updateUser()
    {
        if (!auth()->user()->hasPermission('edit users')) {
            abort(403);
        }
        
        $this->validate([
            'name' => 'required|min:3',
            'email' => 'required|email|unique:users,email,' . $this->userId,
            'role' => 'required',
            'school_id' => 'nullable',
        ]);

        $user = User::findOrFail($this->userId);
        $user->update([
            'name' => $this->name,
            'email' => $this->email,
            'role' => $this->role,
            'school_id' => $this->school_id,
        ]);

        if ($this->password) {
            $user->update(['password' => Hash::make($this->password)]);
        }

        $this->showEditModal = false;
        $this->reset(['name', 'email', 'password', 'role', 'school_id', 'userId']);
    }

    public function deleteUser($id)
    {
        if (!auth()->user()->hasPermission('delete users')) {
            abort(403);
        }
        
        $this->userId = $id;
        $this->showDeleteModal = true;
    }

    public function confirmDelete()
    {
        if (!auth()->user()->hasPermission('delete users')) {
            abort(403);
        }
        
        User::findOrFail($this->userId)->delete();
        $this->showDeleteModal = false;
        $this->reset(['userId']);
    }

    public function closeModal()
    {
        $this->showAddModal = false;
        $this->showAddSaasAdminModal = false;
        $this->showEditModal = false;
        $this->showDeleteModal = false;
        $this->showViewModal = false;
        $this->reset(['name', 'email', 'password', 'role', 'school_id', 'userId', 'viewUserId']);
        $this->role = 'student';
    }

    public function render()
    {
        $users = User::query()
            ->when($this->userType === 'school', function ($query) {
                $query->whereNotNull('school_id');
            })
            ->when($this->userType === 'saas', function ($query) {
                $query->whereNull('school_id')->where('role', '!=', 'super_admin');
            })
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('email', 'like', '%' . $this->search . '%');
            })
            ->when($this->roleFilter, function ($query) {
                $query->where('role', $this->roleFilter);
            })
            ->with(['school'])
            ->latest()
            ->paginate(10);

        $schools = School::where('is_active', true)->get();
        $viewUser = $this->viewUserId ? User::with(['school'])
            ->withCount(['staff', 'student'])
            ->find($this->viewUserId) : null;
        
        // Load staff or student data if exists
        if ($viewUser) {
            if ($viewUser->role === 'teacher' || $viewUser->role === 'school_admin') {
                $viewUser->load('staff');
            } elseif ($viewUser->role === 'student') {
                $viewUser->load('student');
            }
        }

        return view('livewire.platform.super-admin-users', compact('users', 'schools', 'viewUser'))
            ->layout('layouts.app')
            ->title('User Management');
    }
}
