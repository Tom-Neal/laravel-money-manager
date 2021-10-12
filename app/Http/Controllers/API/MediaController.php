<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\MediaLibrary\Support\MediaStream;

class MediaController extends Controller
{

    public function index()
    {
        return MediaStream::create('file-storage.zip')->addMedia(
            // Todo - Passport
            User::find(1)->getMedia('media')
        );
    }

    public function show(Media $media)
    {
        return $media;
    }

}
