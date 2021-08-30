<?php

namespace App\Http\Livewire;

use App\Models\Client;
use Livewire\Component;

class ClientEditPage extends Component
{

    public Client $client;

    public function rules(): array
    {
        return [
            'client.name'  => 'required|string',
            'client.email' => 'nullable|string',
            'client.phone' => 'nullable|string',
        ];
    }

    public function render()
    {
        return view('livewire.client-edit-page');
    }

    public function update($propertyName)
    {
        $this->validateOnly($propertyName);
        $this->client->save();
        $this->dispatchBrowserEvent(
            'notify', ['message' => 'Client Updated']
        );
    }

    public function destroy()
    {
        $clientTypeId = $this->client->client_type_id;
        $this->client->delete();
        return redirect()->to('client-types/show/' . $clientTypeId);
    }

    public function setInitialInputs()
    {

    }

}
