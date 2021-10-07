<?php

namespace App\Http\Livewire;

use App\Models\{Client, Business, Project};
use Livewire\Component;

class ClientEditPage extends Component
{

    public Client $client;
    public string $projectName = '';
    public string $businessName = '';

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
            'client.projects.*.name'    => 'required|string',
            'client.businesses.*.name'  => 'required|string',
        ];
    }

    public function render()
    {
        return view('livewire.client-edit-page');
    }

    public function mount()
    {
        $this->client->load('address', 'projects', 'businesses');
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
        $this->client->address->save();
        $this->dispatchBrowserEvent(
            'notify', ['type' => 'success', 'message' => 'Client address updated']
        );
    }

    public function storeProject()
    {
        $this->client->projects()->create([
            'name' => $this->projectName
        ]);
        $this->client->refresh();
        $this->projectName = '';
        $this->dispatchBrowserEvent(
            'notify', ['type' => 'success', 'message' => 'Project Added']
        );
    }

    public function updateProject($propertyName)
    {
        $this->validateOnly($propertyName);
        $this->client->projects->each->save();
        $this->dispatchBrowserEvent(
            'notify', ['message' => 'Project Updated']
        );
    }

    public function destroyProject(Project $project)
    {
        $project->delete();
        $this->client->refresh();
        $this->dispatchBrowserEvent(
            'notify', ['type' => 'danger', 'message' => 'Project Deleted']
        );
    }

    public function addProject()
    {
        $this->projects[] = [''];
    }

    public function storeBusiness()
    {
        $this->client->businesses()->create([
            'name' => $this->businessName
        ]);
        $this->client->refresh();
        $this->businessName = '';
        $this->dispatchBrowserEvent(
            'notify', ['type' => 'success', 'message' => 'Business Added']
        );
    }

    public function updateBusiness($propertyName)
    {
        $this->validateOnly($propertyName);
        $this->client->businesses->each->save();
        $this->dispatchBrowserEvent(
            'notify', ['message' => 'Business Updated']
        );
    }

    public function destroyBusiness(Business $business)
    {
        $business->delete();
        $this->client->refresh();
        $this->dispatchBrowserEvent(
            'notify', ['type' => 'danger', 'message' => 'Business Deleted']
        );
    }

    public function addBusiness()
    {
        $this->businesses[] = [''];
    }

    public function destroy()
    {
        $clientTypeId = $this->client->client_type_id;
        $this->client->delete();
        return redirect()->to('client-types/show/' . $clientTypeId);
    }

}
