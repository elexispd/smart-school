<?php

namespace App\Livewire;

use App\Imports\UsersImport;
use Livewire\Component;
use Livewire\WithFileUploads;
use Maatwebsite\Excel\Facades\Excel;

class ImportUsers extends Component
{
    use WithFileUploads;

    public $file;

    public function import()
    {
        $this->validate([
            'file' => 'required|mimes:xlsx,xls,csv',
        ]);

        Excel::import(new UsersImport, $this->file);

        $this->dispatch('users-imported');
        $this->reset('file');
        session()->flash('status', 'Users imported successfully.');
    }

    public function render()
    {
        return view('livewire.import-users');
    }
}
