<?php
declare(strict_types=1);
return [
    'credentials' => [
        'secret_id' => env('QCLOUD_SECRET_ID'),
        'secret_key' => env('QCLOUD_SECRET_KEY')
    ],
    'cos' => [
        'region' => env('COS_REGION'),
        'bucket' => env('COS_BUCKET')
    ]
];