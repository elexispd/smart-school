<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class ProfilePictureUpload extends Component
{
    use WithFileUploads;

    public $photo;
    public $currentPhoto;
    public $model;
    public $field = 'avatar';

    public function mount($model, $field = 'avatar')
    {
        $this->model = $model;
        $this->field = $field;
        $this->currentPhoto = $model->{$field};
    }

    public function updatedPhoto()
    {
        $this->validate([
            'photo' => 'image|max:2048',
        ]);
    }

    public function save()
    {
        $this->validate([
            'photo' => 'required|image|max:2048',
        ]);

        if ($this->currentPhoto) {
            Storage::disk('public')->delete($this->currentPhoto);
        }

        $path = $this->photo->store('avatars', 'public');
        $this->model->update([$this->field => $path]);
        $this->currentPhoto = $path;
        $this->photo = null;

        $this->dispatch('photo-uploaded')->self();
    }

    public function remove()
    {
        if ($this->currentPhoto) {
            Storage::disk('public')->delete($this->currentPhoto);
            $this->model->update([$this->field => null]);
            $this->currentPhoto = null;
        }

        $this->dispatch('photo-removed');
    }

    public function render()
    {
        return view('livewire.profile-picture-upload');
    }
}
