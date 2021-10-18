<?php

namespace App\Http\Controllers;

class CommentController extends Controller
{

    public function __invoke()
    {
        return view('comments.index');
    }

}
