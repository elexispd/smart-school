<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Activitylog\Models\Activity;
use App\Models\School;

class SaasActivityLogs extends Component
{
    use WithPagination;

    public $activeTab = 'saas';
    public $search = '';
    public $selectedSchool = '';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingSelectedSchool()
    {
        $this->resetPage();
    }

    public function switchTab($tab)
    {
        $this->activeTab = $tab;
        $this->search = '';
        $this->selectedSchool = '';
        $this->resetPage();
    }

    public function render()
    {
        if (!auth()->user()->hasPermission('view logs')) {
            abort(403);
        }
        
        $schools = School::orderBy('name')->get();

        if ($this->activeTab === 'saas') {
            $activities = Activity::query()
                ->with(['causer', 'subject'])
                ->where('log_name', 'saas')
                ->when($this->search, function ($query) {
                    $query->where('description', 'like', '%' . $this->search . '%');
                })
                ->latest()
                ->paginate(20);
        } else {
            $activities = Activity::query()
                ->with(['causer', 'subject'])
                ->where('log_name', 'school')
                ->when($this->selectedSchool, function ($query) {
                    $query->where('school_id', $this->selectedSchool);
                })
                ->when($this->search, function ($query) {
                    $query->where('description', 'like', '%' . $this->search . '%');
                })
                ->latest()
                ->paginate(20);
        }

        return view('livewire.platform.saas-activity-logs', compact('activities', 'schools'))
            ->layout('layouts.app')
            ->title('Activity Logs');
    }
}
