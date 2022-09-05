<?php

if (config('app.env')=='production') {
    return [
        'class_namespace' => 'App\\Http\\Livewire',

        'view_path' => resource_path('views/livewire'),

        'layout' => 'layouts.app',

        'asset_url' => config('app.url').'public/',

        'app_url' => config('app.url'),

        'middleware_group' => 'web',

        'temporary_file_upload' => [
            'disk' => null,        // Example: 'local', 's3'              Default: 'default'
            'rules' => null,       // Example: ['file', 'mimes:png,jpg']  Default: ['required', 'file', 'max:12288'] (12MB)
            'directory' => null,   // Example: 'tmp'                      Default  'livewire-tmp'
            'middleware' => null,  // Example: 'throttle:5,1'             Default: 'throttle:60,1'
            'preview_mimes' => [   // Supported file types for temporary pre-signed file URLs.
                'png', 'gif', 'bmp', 'svg', 'wav', 'mp4',
                'mov', 'avi', 'wmv', 'mp3', 'm4a',
                'jpg', 'jpeg', 'mpga', 'webp', 'wma',
            ],
            'max_upload_time' => 5, // Max duration (in minutes) before an upload gets invalidated.
        ],

        'manifest_path' => null,

        'back_button_cache' => false,

        'render_on_redirect' => false,

    ];
} else {
    return [
        'class_namespace' => 'App\\Http\\Livewire',

        'view_path' => resource_path('views/livewire'),

        'layout' => 'layouts.app',

        'asset_url' => '',

        'app_url' => '',

        'middleware_group' => 'web',

        'temporary_file_upload' => [
            'disk' => null,        // Example: 'local', 's3'              Default: 'default'
            'rules' => null,       // Example: ['file', 'mimes:png,jpg']  Default: ['required', 'file', 'max:12288'] (12MB)
            'directory' => null,   // Example: 'tmp'                      Default  'livewire-tmp'
            'middleware' => null,  // Example: 'throttle:5,1'             Default: 'throttle:60,1'
            'preview_mimes' => [   // Supported file types for temporary pre-signed file URLs.
                'png', 'gif', 'bmp', 'svg', 'wav', 'mp4',
                'mov', 'avi', 'wmv', 'mp3', 'm4a',
                'jpg', 'jpeg', 'mpga', 'webp', 'wma',
            ],
            'max_upload_time' => 5, // Max duration (in minutes) before an upload gets invalidated.
        ],

        'manifest_path' => null,

        'back_button_cache' => false,

        'render_on_redirect' => false,

    ];
}

