<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Image Driver
    |--------------------------------------------------------------------------
    |
    | Intervention Image supports "GD Library" and "Imagick" to process images
    | internally. You may choose one of them according to your PHP
    | configuration. By default PHP's "GD Library" implementation is used.
    |
    | Supported: "gd", "imagick"
    |
    */

    'driver' => env('IMAGE_DRIVER', 'gd'),

    /*
    |--------------------------------------------------------------------------
    | Image Quality
    |--------------------------------------------------------------------------
    |
    | The quality setting for JPEG images. The value ranges from 0 to 100.
    | A higher value means better quality but larger file size.
    |
    */

    'quality' => env('IMAGE_QUALITY', 85),

    /*
    |--------------------------------------------------------------------------
    | Image Cache
    |--------------------------------------------------------------------------
    |
    | Cache settings for processed images.
    |
    */

    'cache' => [
        'enabled' => env('IMAGE_CACHE_ENABLED', true),
        'lifetime' => env('IMAGE_CACHE_LIFETIME', 43200), // 12 hours
    ],

    /*
    |--------------------------------------------------------------------------
    | Image Sizes
    |--------------------------------------------------------------------------
    |
    | Default image sizes for different purposes.
    |
    */

    'sizes' => [
        'thumbnail' => [
            'width' => 150,
            'height' => 150,
        ],
        'medium' => [
            'width' => 300,
            'height' => 300,
        ],
        'large' => [
            'width' => 800,
            'height' => 600,
        ],
        'full' => [
            'width' => 1200,
            'height' => null, // null means maintain aspect ratio
        ],
    ],

]; 