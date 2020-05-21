<?php
declare(strict_types=1);

namespace App\Controller;

class IndexController
{
    public function index(): array
    {
        return [
            'version' => 1.2,
            'unixtime' => time()
        ];
    }
}
