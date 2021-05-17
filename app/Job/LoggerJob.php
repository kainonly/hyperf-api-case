<?php
declare(strict_types=1);

namespace App\Job;

use Hyperf\AsyncQueue\Job;
use Hyperf\DbConnection\Db;

class LoggerJob extends Job
{
    public array $params;

    public function __construct(array $params)
    {
        $this->params = $params;
    }

    public function handle(): void
    {
        switch ($this->params['channel']) {
            case 'request':
                Db::table('logs')->insert($this->params['values']);
                break;
            case 'login':
                Db::table('activities')->insert($this->params['values']);
                break;
        }
    }
}