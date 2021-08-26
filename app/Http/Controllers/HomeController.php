<?php

namespace App\Http\Controllers;

class HomeController extends Controller
{

    public function __invoke()
    {
        if (auth()->user()) {
            return view('home');
        }
        return redirect('login');
    }

}
