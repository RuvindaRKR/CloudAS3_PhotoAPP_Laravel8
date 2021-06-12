<?php

return [
    'credentials' => [
        'key'    => array_key_exists('AWS_ACCESS_KEY_ID', $_SERVER) ? $_SERVER['AWS_ACCESS_KEY_ID'] :env('AWS_ACCESS_KEY_ID'),
        //'secret' => env('AWS_SECRET_ACCESS_KEY', ''),
        'secret' => array_key_exists('AWS_SECRET_ACCESS_KEY', $_SERVER) ? $_SERVER['AWS_SECRET_ACCESS_KEY'] :env('AWS_SECRET_ACCESS_KEY'),
    ],
    'region' => array_key_exists('AWS_DEFAULT_REGION', $_SERVER) ? $_SERVER['AWS_DEFAULT_REGION'] :env('AWS_DEFAULT_REGION'),
    'version' => 'latest',
    
    // You can override settings for specific services
    // 'Ses' => [
    //     'region' => 'us-east-1',
    // ],
];
