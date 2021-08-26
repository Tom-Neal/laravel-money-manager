<?php

namespace App\Http\Controllers;

class ErrorController extends Controller
{

    public function lost()
    {
        return redirect()->away('https://www.youtube.com/watch?v=dQw4w9WgXcQ');
    }

}
