<?php
declare(strict_types=1);

namespace App\Service;

use App\Job\LogsJob;
use App\Job\ActivitiesJob;
use Hyperf\AsyncQueue\Driver\DriverFactory;
use Hyperf\AsyncQueue\Driver\DriverInterface;

class LoggerService
{
    /**
     * @var DriverInterface
     */
    private DriverInterface $driver;

    public function __construct(DriverFactory $driverFactory)
    {
        $this->driver = $driverFactory->get('default');
    }

    public function logs($params): bool
    {
        return $this->driver->push(new LogsJob($params));
    }

    public function activities($params): bool
    {
        return $this->driver->push(new ActivitiesJob($params));
    }
}