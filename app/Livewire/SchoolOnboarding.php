<?php

namespace App\Livewire;

use App\Models\School;
use App\Models\User;
use App\Notifications\SchoolOnboardingCompleted;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Str;
use Livewire\Component;

class SchoolOnboarding extends Component
{
    // School Information
    public $school_name;
    public $acronym;

    // Admin Credentials
    public $admin_name; // Added as it's required for User creation
    public $admin_email;
    public $admin_password;

    // Contact Information
    public $school_email;
    public $school_phone;
    public $school_moto;

    // Location Details
    public $address;
    public $city;
    public $country;
    public $state;

    protected $rules = [
        'school_name' => 'required|string|max:255',
        'acronym' => 'required|string|max:10',
        'admin_name' => 'required|string|max:255',
        'admin_email' => 'required|email|unique:users,email',
        'admin_password' => 'required|min:8',
        'school_email' => 'required|email',
        'school_phone' => 'required|string',
        'school_moto' => 'nullable|string|max:255',
        'address' => 'required|string',
        'city' => 'required|string',
        'country' => 'required|string',
        'state' => 'required|string',
    ];

    public function register()
    {
        $this->validate();

        $school = School::create([
            'name' => $this->school_name,
            'slug' => Str::slug($this->school_name),
            'acronym' => $this->acronym,
            'email' => $this->school_email,
            'phone' => $this->school_phone,
            'moto' => $this->school_moto,
            'address' => $this->address,
            'city' => $this->city,
            'state' => $this->state,
            'country' => $this->country,
            'is_active' => true,
            'status' => 'approved',
        ]);

        User::create([
            'name' => $this->admin_name,
            'email' => $this->admin_email,
            'password' => Hash::make($this->admin_password),
            'school_id' => $school->id,
            'role' => 'school_admin',
        ]);

        // Send email to admin
        Notification::route('mail', $this->admin_email)
            ->notify(new SchoolOnboardingCompleted($school, $this->admin_name, $this->admin_email));

        session()->flash('message', 'School onboarded successfully!');
        return redirect()->route('super_admin.schools');
    }

    public function render()
    {
        return view('livewire.platform.schools.school-onboarding')
            ->layout('layouts.app')
            ->title('School Onboarding');
    }
}
