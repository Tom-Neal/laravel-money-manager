<?php

namespace App\Http\Controllers;

use App\Http\Requests\ClientTypeRequest;
use App\Models\ClientType;
use Illuminate\Support\Str;

class ClientTypeController extends Controller
{

    public function index()
    {
        $clientTypes = ClientType::withCount('clients')->get();
        return view('client_types.index')
            ->with(compact('clientTypes'));
    }

    public function create()
    {
        return view('client_types.create');
    }

    public function store(ClientTypeRequest $request)
    {
        ClientType::create(request([
                'name', 'description', 'icon'
            ]) + [
                'slug' => Str::slug(request()['name'])
            ]);
        return redirect('client-types')
            ->with('message', 'Client Type Created');
    }

    public function show(ClientType $clientType)
    {
        $clientType->load('clients.lastInvoice');
        return view('client_types.show')
            ->with(compact('clientType'));
    }

    public function edit(ClientType $clientType)
    {
        return view('client_types.edit')
            ->with(compact('clientType'));
    }

    public function update(ClientTypeRequest $request, ClientType $clientType)
    {
        $clientType->update(request([
                'name', 'description', 'icon'
            ]) + [
                'slug' => Str::slug(request()['name'])
            ]);
        return redirect('client-types')
            ->with('message', 'Client Type Updated');
    }

    public function destroy(ClientType $clientType)
    {
        $clientType->delete();
        return back()
            ->with('message', 'Client Type Deleted');
    }

}
