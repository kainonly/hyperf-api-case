<?php

namespace App\Controller;

use Hyperf\HttpServer\Annotation\AutoController;

/**
 * Class Index
 * @package App\Controller
 * @AutoController()
 */
class Index
{
    /**
     * @return array
     */
    public function index()
    {
        return [
            'version' => 1.0,
        ];
    }

    public function info()
    {
        return phpinfo();
    }
}