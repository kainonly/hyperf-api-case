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
    \Hyperf\Extra\Hash\HashInterface::class => \Hyperf\Extra\Hash\HashService::class,
    \Hyperf\Extra\Token\TokenInterface::class => \Hyperf\Extra\Token\TokenService::class,
    \Hyperf\Extra\Utils\UtilsInterface::class => \Hyperf\Extra\Utils\UtilsService::class,
    \Hyperf\Extra\Cors\CorsInterface::class => \Hyperf\Extra\Cors\CorsService::class
];
