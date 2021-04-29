<?php
declare(strict_types=1);

namespace App\Service;

use App\Job\LoggerJob;
use Hyperf\AsyncQueue\Driver\DriverFactory;
use Hyperf\AsyncQueue\Driver\DriverInterface;

class QueueService
{
    /**
     * @var DriverInterface
     */
    protected DriverInterface $driver;

    public function __construct(DriverFactory $driverFactory)
    {
        $this->driver = $driverFactory->get('default');
    }

    public function logger($params): bool
    {
        return $this->driver->push(new LoggerJob($params), 0);
    }

}