<?php

namespace App\Http\Livewire;

use Livewire\{Component, WithFileUploads};
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist;

class MediaIndexPage extends Component
{
    use WithFileUploads;

    public $files = [];

    public function render()
    {
        return view('livewire.media-index-page');
    }

    public function storeMedia()
    {
        foreach ($this->files as $file) {
            try {
                auth()->user()
                    ->addMediaFromString($file->get())
                    ->usingName($file->getClientOriginalName())
                    ->usingFileName($file->getClientOriginalName())
                    ->toMediaCollection('media');
                $this->dispatchBrowserEvent('reset-files');
                $this->dispatchBrowserEvent(
                    'notify', ['type' => 'success', 'message' => 'File(s) have been uploaded!']
                );
            } catch (FileDoesNotExist $e) {
                $this->dispatchBrowserEvent(
                    'notify', ['type' => 'success', 'message' => 'File(s) could not be uploaded']
                );
            }
        }
        $this->files = [];
        $this->emit('storeMedia');
    }

}
