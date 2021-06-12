<?php
declare(strict_types=1);

namespace App\Job;

use Hyperf\AsyncQueue\Job;
use Hyperf\DbConnection\Db;

class ActivitiesJob extends Job
{
    public array $params;

    protected $maxAttempts = 2;

    public function __construct(array $params)
    {
        $this->params = $params;
    }

    public function handle(): void
    {
        Db::table('activities')->insert($this->params);
    }
}