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
            'client.name'               => 'required|string',
            'client.email'              => 'nullable|string',
            'client.phone'              => 'nullable|string',
            'client.address.name'       => 'nullable|string',
            'client.address.address_1'  => 'nullable|string',
            'client.address.address_2'  => 'nullable|string',
            'client.address.address_3'  => 'nullable|string',
            'client.address.postcode'   => 'nullable|string',
        ];
    }

    public function render()
    {
        return view('livewire.client-edit-page');
    }

    public function mount()
    {
        $this->client->load('address');
    }

    public function update($propertyName)
    {
        $this->validateOnly($propertyName);
        $this->client->save();
        $this->dispatchBrowserEvent(
            'notify', ['message' => 'Client Updated']
        );
    }


    public function updateAddress($propertyName)
    {
        $this->validateOnly($propertyName);
//        dd($this->client->address);
        $this->client->address->save();
        $this->dispatchBrowserEvent(
            'notify', ['type' => 'success', 'message' => 'Client address updated']
        );
    }

    public function destroy()
    {
        $clientTypeId = $this->client->client_type_id;
        $this->client->delete();
        return redirect()->to('client-types/show/' . $clientTypeId);
    }

}
