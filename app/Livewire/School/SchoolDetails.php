<?php

namespace App\Livewire\School;

use App\Models\School;
use Livewire\Component;

class SchoolDetails extends Component
{
    public School $school;
    public $activeTab = 'overview';

    public function mount(School $school)
    {
        $this->school = $school;
    }

    public function setTab($tab)
    {
        $this->activeTab = $tab;
    }

    public function render()
    {
        return view('livewire.school.school-details', [
            'stats' => [
                'students' => $this->school->users()->count(), // Placeholder logic
                'teachers' => 0, // Placeholder
                'courses' => 0, // Placeholder
            ]
        ])->layout('layouts.app')
          ->title($this->school->name . ' - Details');
    }
}
