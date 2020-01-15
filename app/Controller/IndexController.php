<?php
declare(strict_types=1);

namespace App\Controller;

use Hyperf\Di\Annotation\Inject;
use Hyperf\Extra\Contract\HashInterface;

class IndexController
{
    /**
     * @Inject()
     * @var HashInterface
     */
    private HashInterface $hash;

    public function index(): array
    {
        return [
            'version' => 1.0,
            'pwd' => $this->hash->create('1234')
        ];
    }
}
