<?php
declare(strict_types=1);

namespace App\Controller;

use Hyperf\AMQPClient\AMQPClientInterface;
use Hyperf\Di\Annotation\Inject;

class IndexController
{
    /**
     * @Inject()
     * @var AMQPClientInterface
     */
    private AMQPClientInterface $amqp;

    public function index()
    {
        return [
            'version' => 1.0,
            'unixtime' => time()
        ];
    }
}
