<?php

namespace App\Http\Controllers;

use Spatie\MediaLibrary\MediaCollections\Models\Media;

class MediaController extends Controller
{

    public function show(Media $media)
    {
        return $media;
    }

}
