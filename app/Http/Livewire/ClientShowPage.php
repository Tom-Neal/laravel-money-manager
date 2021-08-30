<?php

namespace App\Http\Livewire;

use App\Models\Client;
use Livewire\{Component, WithFileUploads};
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class ClientShowPage extends Component
{
    use WithFileUploads;

    public Client $client;
    public $files = [];

    public function render()
    {
        return view('livewire.client-show-page');
    }

    public function mount()
    {
        $this->invoiceStatuses = InvoiceStatus::all();
        $this->invoiceDateSent = date('Y-m-d', strtotime(NOW()));
    }

    public function storeMedia()
    {
        foreach ($this->files as $file) {
            try {
                $this->client
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
        $this->client->refresh();
    }

    public function destroyMedia(Media $media)
    {
        $media->delete();
        $this->dispatchBrowserEvent(
            'notify', ['type' => 'danger', 'message' => 'File Deleted']
        );
    }

}
