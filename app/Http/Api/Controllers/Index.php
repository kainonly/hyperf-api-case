<?php

namespace App\Http\Api\Controllers;

class Index extends Base
{
    public function index()
    {
        return [
            'status' => 'ok'
        ];
    }
}
