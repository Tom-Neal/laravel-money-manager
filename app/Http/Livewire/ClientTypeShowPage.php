<?php

namespace App\Http\Livewire;

use App\Models\ClientType;
use Livewire\Component;

class ClientTypeShowPage extends Component
{

    public ClientType $clientType;
    public ?string $name = NULL;
    public ?string $email = NULL;

    public function rules(): array
    {
        return [
            'name'  => ['required', 'string'],
            'email' => ['nullable', 'email'],
        ];
    }

    public function render()
    {
        $clients = $this->clientType
            ->clients()
            ->with('lastInvoice')
            ->latest()
            ->paginate(20);
        return view('livewire.client-type-show-page')
            ->with(compact('clients'));
    }

    public function store()
    {
        $this->validate();
        $this->clientType->clients()->create([
            'name'  => $this->name,
            'email' => $this->email
        ])->address()->create();
        $this->name = $this->email = NULL;
        $this->dispatchBrowserEvent(
            'notify', ['type' => 'success', 'message' => 'Web Development Added']
        );
    }

}
