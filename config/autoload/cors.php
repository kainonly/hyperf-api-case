<?php
return [

    /*
    * Matches the request method. `[*]` allows all methods.
    */
    'allowed_methods' => explode(',', env('CORS_METHODS', '*')),

    /*
     * Matches the request origin. `[*]` allows all origins.
     */
    'allowed_origins' => explode(',', env('CORS_ORIGINS', '*')),

    /*
     * Sets the Access-Control-Allow-Headers response header. `[*]` allows all headers.
     */
    'allowed_headers' => explode(',', env('CORS_HEADERS', 'CONTENT-TYPE,X-REQUESTED-WITH')),

    /*
     * Sets the Access-Control-Expose-Headers response header.
     */
    'exposed_headers' => explode(',', env('CORS_EXPOSED_HEADERS', '')),

    /*
     * Sets the Access-Control-Max-Age response header.
     */
    'max_age' => (int)env('CORS_MAX_AGE', 0),

    /*
     * Sets the Access-Control-Allow-Credentials header.
     */
    'allowed_credentials' => env('CORS_CREDENTIALS', false),
];