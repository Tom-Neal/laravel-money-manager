<?php

namespace App\Http\Controllers;

class MediaController extends Controller
{

    public function __invoke()
    {
        return view('media.index');
    }

}
