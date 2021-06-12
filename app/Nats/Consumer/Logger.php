<?php
declare(strict_types=1);

namespace App\Nats\Consumer;

use Hyperf\DbConnection\Db;
use Hyperf\Nats\AbstractConsumer;
use Hyperf\Nats\Annotation\Consumer;
use Hyperf\Nats\Message;

/**
 * @Consumer(subject="logger.*", queue="logger", name ="Logger", nums=1)
 */
class Logger extends AbstractConsumer
{
    public function consume(Message $payload): void
    {
        $body = (array)$payload->getBody();
        switch ($payload->getSubject()) {
            case 'logger.logs':
                Db::table('logs')->insert($body);
                break;
            case 'logger.activities':
                Db::table('activities')->insert($body);
                break;
        }
    }
}
