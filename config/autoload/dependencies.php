<?php

declare(strict_types=1);
/**
 * This file is part of Hyperf.
 *
 * @link     https://www.hyperf.io
 * @document https://doc.hyperf.io
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf-cloud/hyperf/blob/master/LICENSE
 */

return [
    \Hyperf\Extra\Contract\HashInterface::class => \Hyperf\Extra\Service\HashService::class,
    \Hyperf\Extra\Contract\TokenInterface::class => \Hyperf\Extra\Service\TokenService::class,
    \Hyperf\Extra\Contract\UtilsInterface::class => \Hyperf\Extra\Service\UtilsService::class,
    \Hyperf\Extra\Contract\CorsInterface::class => \Hyperf\Extra\Service\CorsService::class
];
