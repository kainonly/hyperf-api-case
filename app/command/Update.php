<?php

namespace app\command;

use think\console\Command;
use think\console\Input;
use think\console\Output;

class Update extends Command
{
    protected function configure()
    {
        $this->setName('update');
    }

    protected function execute(Input $input, Output $output)
    {
        exec('composer update --optimize-autoloader --no-dev --ignore-platform-reqs --no-scripts');
    }
}
