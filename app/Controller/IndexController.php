<?php
declare(strict_types=1);

namespace App\Controller;

use Hyperf\AMQPClient\AMQPClientInterface;
use Hyperf\Di\Annotation\Inject;
use simplify\amqp\AMQPManager;

class IndexController
{
    /**
     * @Inject()
     * @var AMQPClientInterface
     */
    private AMQPClientInterface $amqp;

    public function index()
    {
        $this->amqp->channel(function (AMQPManager $manager) {
        });
        return [
            'version' => 1.0,
            'unixtime' => time()
        ];
    }
}
