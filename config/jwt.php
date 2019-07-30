<?php

use Lcobucci\JWT\Signer\Hmac\Sha256;

return [
    'signer' => new Sha256(),
    'expires' => 3600,
    'erp' => [
        'issuer' => env('ERP_ISSUER'),
        'audience' => env('ERP_AUDIENCE')
    ]
];
