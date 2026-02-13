<?php

namespace App\Livewire\School;

use App\Models\Session;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;

class ManageSessions extends Component
{
    use WithPagination;

    public $search = '';
    public $showModal = false;
    public $showDeleteModal = false;
    public $sessionId;
    public $name, $start_date, $end_date, $current_term;

    protected function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after:start_date',
            'current_term' => 'nullable|in:first,second,third',
        ];
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function create()
    {
        if (auth()->user()->role !== 'school_admin') abort(403);
        
        $this->reset(['name', 'start_date', 'end_date', 'current_term', 'sessionId']);
        $this->showModal = true;
    }

    public function edit($id)
    {
        if (auth()->user()->role !== 'school_admin') abort(403);
        
        $session = Session::findOrFail($id);
        $this->sessionId = $id;
        $this->name = $session->name;
        $this->start_date = $session->start_date->format('Y-m-d');
        $this->end_date = $session->end_date->format('Y-m-d');
        $this->current_term = $session->current_term;
        $this->showModal = true;
    }

    public function save()
    {
        if (auth()->user()->role !== 'school_admin') abort(403);
        
        $this->validate();

        DB::transaction(function () {
            $data = [
                'school_id' => auth()->user()->school_id,
                'name' => $this->name,
                'start_date' => $this->start_date,
                'end_date' => $this->end_date,
                'current_term' => $this->current_term,
            ];

            if ($this->sessionId) {
                $session = Session::findOrFail($this->sessionId);
                $session->update($data);
                activity('school')
                    ->performedOn($session)
                    ->causedBy(auth()->user())
                    ->withProperties(['school_id' => $session->school_id])
                    ->tap(function ($activity) use ($session) {
                        $activity->school_id = $session->school_id;
                    })
                    ->log('Updated session: ' . $session->name);
            } else {
                $session = Session::create($data);
                activity('school')
                    ->performedOn($session)
                    ->causedBy(auth()->user())
                    ->withProperties(['school_id' => $session->school_id])
                    ->tap(function ($activity) use ($session) {
                        $activity->school_id = $session->school_id;
                    })
                    ->log('Created session: ' . $session->name);
            }
        });

        $this->closeModal();
    }

    public function setCurrent($id)
    {
        if (auth()->user()->role !== 'school_admin') abort(403);
        
        DB::transaction(function () use ($id) {
            Session::where('school_id', auth()->user()->school_id)->update(['is_current' => false]);
            $session = Session::findOrFail($id);
            $session->update(['is_current' => true]);
            
            activity('school')
                ->performedOn($session)
                ->causedBy(auth()->user())
                ->withProperties(['school_id' => $session->school_id])
                ->tap(function ($activity) use ($session) {
                    $activity->school_id = $session->school_id;
                })
                ->log('Set session as current: ' . $session->name);
        });
    }

    public function delete($id)
    {
        if (auth()->user()->role !== 'school_admin') abort(403);
        
        $this->sessionId = $id;
        $this->showDeleteModal = true;
    }

    public function confirmDelete()
    {
        if (auth()->user()->role !== 'school_admin') abort(403);
        
        $session = Session::findOrFail($this->sessionId);
        $sessionName = $session->name;
        $schoolId = $session->school_id;
        
        $session->delete();
        
        activity('school')
            ->causedBy(auth()->user())
            ->withProperties(['school_id' => $schoolId])
            ->tap(function ($activity) use ($schoolId) {
                $activity->school_id = $schoolId;
            })
            ->log('Deleted session: ' . $sessionName);
        
        $this->showDeleteModal = false;
        $this->reset(['sessionId']);
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->showDeleteModal = false;
        $this->reset(['name', 'start_date', 'end_date', 'current_term', 'sessionId']);
    }

    public function render()
    {
        $sessions = Session::query()
            ->when($this->search, fn($q) => $q->where('name', 'like', '%' . $this->search . '%'))
            ->latest()
            ->paginate(10);

        return view('livewire.school.manage-sessions', compact('sessions'))
            ->layout('layouts.app')
            ->title('Manage Sessions');
    }
}
