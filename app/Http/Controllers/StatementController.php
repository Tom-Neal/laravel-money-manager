<?php

namespace App\Http\Controllers;

class StatementController extends Controller
{

    public function __invoke()
    {
        return view('statements.index');
    }

}
