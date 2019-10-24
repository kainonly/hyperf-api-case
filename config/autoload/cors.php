<?php
return [
    'allow_origin' => explode(',', env('cors')),
    'allow_credentials' => true,
    'allow_methods' => ['POST'],
    'expose_headers' => [],
    'allow_headers' => ['CONTENT-TYPE', 'X-REQUESTED-WITH'],
    'max_age' => 31536000,
];