<?php

namespace App\Http\Controllers;

use App\Models\Client;

class ClientController extends Controller
{

    public function show(Client $client)
    {
        return view('clients.show')->with(compact('client'));
    }

    public function edit(Client $client)
    {
        return view('clients.edit')->with(compact('client'));
    }

}
