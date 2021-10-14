<?php

namespace App\Http\Controllers;

use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\MediaLibrary\Support\MediaStream;

class MediaDownloadController extends Controller
{

    public function index()
    {
        return MediaStream::create('file-storage.zip')->addMedia(
            auth()->user()->getMedia('media')
        );
    }

    public function show(Media $media)
    {
        return $media;
    }

}
