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
    \Hyperf\Extra\Contract\HashServiceInterface::class => \Hyperf\Extra\Common\HashServiceFactory::class,
    \Hyperf\Extra\Contract\UtilsServiceInterface::class => \Hyperf\Extra\Common\UtilsServiceFactory::class,
    \Hyperf\Extra\Contract\TokenServiceInterface::class => \Hyperf\Extra\Common\TokenServiceFactory::class
];
