<?php

namespace App\Http\Livewire;

use App\Models\{Client, Comment, InvoiceStatus};
use Livewire\{Component, WithFileUploads};
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use App\Helpers\CurrencyHelper;

class ClientShowPage extends Component
{
    use WithFileUploads;

    public Client $client;
    public $invoiceStatuses;
    public $invoiceTotal = NULL;
    public ?string $invoiceDateSent = NULL;
    public ?string $invoiceDatePaid = NULL;
    public string $invoiceSum = '';
    public int $invoiceDateStatusId = 1;
    public string $commentDescription = '';
    public $files = [];

    public function rules(): array
    {
        return [
            'invoiceTotal'        => ['required', 'integer'],
            'invoiceDateSent'     => ['nullable', 'string'],
            'invoiceDatePaid'     => ['nullable', 'string'],
            'invoiceDateStatusId' => ['required', 'integer'],
            'commentDescription'  => ['required', 'string'],
        ];
    }

    public function render()
    {
        $this->client->load('invoices.invoiceStatus', 'invoices.items', 'comments');
        return view('livewire.client-show-page');
    }

    public function mount()
    {
        $this->invoiceStatuses = InvoiceStatus::all();
        $this->invoiceDateSent = date('Y-m-d', strtotime(NOW()));
        $this->invoiceSum = CurrencyHelper::getFormattedValue($this->client->invoices()->paid()->sum('total'));
    }

    public function storeInvoice()
    {
        $this->client->invoices()->create([
            'number'            => $this->client->newInvoiceNumber(),
            'total'             => $this->invoiceTotal,
            'date_sent'         => $this->invoiceDateSent,
            'date_paid'         => $this->invoiceDatePaid,
            'invoice_status_id' => $this->invoiceDateStatusId,
        ]);
        $this->reset('invoiceTotal', 'invoiceDateSent', 'invoiceDatePaid', 'invoiceDateStatusId');
        $this->emit('storeInvoice');
        $this->dispatchBrowserEvent(
            'notify', ['type' => 'success', 'message' => 'Invoice Added']
        );
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
        $this->emit('storeMedia');
    }

    public function destroyMedia(Media $media)
    {
        $media->delete();
        $this->client->refresh();
        $this->dispatchBrowserEvent(
            'notify', ['type' => 'danger', 'message' => 'File Deleted']
        );
    }

    public function storeComment()
    {
        $this->validateOnly('commentDescription');
        $this->client->comments()->create([
            'description' => $this->commentDescription
        ]);
        $this->commentDescription = '';
        $this->dispatchBrowserEvent(
            'notify', ['type' => 'success', 'message' => 'Comment Added']
        );
    }

    public function destroyComment(Comment $comment)
    {
        $comment->delete();
        $this->dispatchBrowserEvent(
            'notify', ['type' => 'danger', 'message' => 'Comment Removed']
        );
    }

}
