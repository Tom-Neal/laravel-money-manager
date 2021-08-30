<?php

namespace App\Http\Controllers;

use App\Models\ClientType;

class HomeController extends Controller
{

    public function __invoke()
    {
        if (auth()->user()) {
            $clientTypes = ClientType::all();
            return view('home')
                ->with(compact('clientTypes'));
        }
        return redirect('login');
    }

}
