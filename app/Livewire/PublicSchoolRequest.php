<?php

namespace App\Livewire;

use App\Models\School;
use App\Models\User;
use App\Notifications\SchoolRequestReceived;
use Illuminate\Support\Str;
use Livewire\Component;

class PublicSchoolRequest extends Component
{
    public $school_name = '';
    public $acronym = '';
    public $school_email = '';
    public $phone = '';
    public $moto = '';
    public $admin_name = '';
    public $admin_email = '';
    public $admin_password = '';
    public $address = '';
    public $city = '';
    public $state = '';
    public $country = '';
    public $message = '';
    public $submitted = false;

    protected $rules = [
        'school_name' => 'required|min:3',
        'acronym' => 'nullable|string',
        'school_email' => 'required|email',
        'phone' => 'required',
        'moto' => 'nullable|string',
        'admin_name' => 'required',
        'admin_email' => 'required|email',
        'admin_password' => 'required|min:8',
        'address' => 'required',
        'city' => 'required',
        'state' => 'required',
        'country' => 'required',
    ];

    public function submit()
    {
        $this->validate();

        $school = School::create([
            'name' => $this->school_name,
            'slug' => Str::slug($this->school_name),
            'acronym' => $this->acronym,
            'email' => $this->school_email,
            'phone' => $this->phone,
            'moto' => $this->moto,
            'address' => $this->address,
            'city' => $this->city,
            'state' => $this->state,
            'country' => $this->country,
            'status' => 'pending',
            'is_active' => false,
        ]);

        // Create school admin user
        User::create([
            'name' => $this->admin_name,
            'email' => $this->admin_email,
            'password' => bcrypt($this->admin_password),
            'role' => 'school_admin',
            'school_id' => $school->id,
        ]);

        $this->submitted = true;
    }

    public function render()
    {
        return view('livewire.public-school-request')
            ->layout('layouts.guest')
            ->title('Request School Onboarding');
    }
}
