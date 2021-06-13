<?php
declare(strict_types=1);
return [
    'app_id' => env('QCLOUD_APP_ID'),
    'secret_id' => env('QCLOUD_SECRET_ID'),
    'secret_key' => env('QCLOUD_SECRET_KEY'),
    'cos' => [
        'region' => env('COS_REGION'),
        'bucket' => env('COS_BUCKET'),
        'prefix' => env('COS_PREFIX', ''),
        'upload_size' => (int)env('COS_UPLOAD_SIZE', 5242880)
    ],
    'api' => [
        'url' => env('QCLOUD_API'),
        'token' => env('QCLOUD_TOKEN'),
    ]
];