<?php

namespace App\Helpers;

use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\MediaLibrary\Support\PathGenerator\DefaultPathGenerator;

class EnvironmentPathGenerator extends DefaultPathGenerator
{

    /*
     * Get a unique base path for the given media based on the client
     */
    protected function getBasePath(Media $media): string
    {
        return DIRECTORY_SEPARATOR . 'media' . DIRECTORY_SEPARATOR . $media->getKey();
    }

}