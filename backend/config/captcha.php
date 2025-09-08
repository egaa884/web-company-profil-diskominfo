<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Default Captcha Configuration
    |--------------------------------------------------------------------------
    |
    | Here you may specify which of the captcha connections below you wish
    | to use as your default connection for all captcha work.
    |
    */

    'default' => 'image',

    /*
    |--------------------------------------------------------------------------
    | Captcha Connections
    |--------------------------------------------------------------------------
    |
    | Here are each of the captcha connections setup for your application.
    | Of course, examples of configuring each captcha platform.
    |
    */

    'connections' => [

        'image' => [
            'width' => 120,
            'height' => 36,
            'length' => 5,
            'quality' => 90,
            'math' => false,
            'expire' => 60,
            'encrypt' => false,
            'lines' => 3,
            'bgImage' => false,
            'bgColor' => '#ecf2f4',
            'fontColors' => ['#2c3e50', '#c0392b', '#16a085', '#c0392b', '#8e44ad', '#303f9f', '#f57c00', '#795548'],
            'contrast' => -5,
            'fontSize' => 20,
            'fonts' => [],
        ],

    ],
];
