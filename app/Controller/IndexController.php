<?php
declare(strict_types=1);

namespace App\Controller;

class IndexController
{
    public function index(): array
    {
        return [
            'v' => 2.0,
        ];
    }
}
