<?php
declare (strict_types=1);

namespace App\HttpClient;

use Docker\Api\DockerClient;
use Hyperf\Guzzle\ClientFactory;

class DockerService
{
    private ClientFactory $clientFactory;
    private DockerClient $dockerClient;

    public function __construct(ClientFactory $clientFactory)
    {
        $this->clientFactory = $clientFactory;

    }

    /**
     * @param string $uri
     * @return $this
     */
    public function client(int $port): self
    {
        $this->dockerClient = new DockerClient($this->clientFactory->create([
            'base_uri' => 'http://127.0.0.1:' . $port,
            'timeout' => 2.0,
        ]));
        return $this;
    }

    /**
     * @return array
     */
    public function info(): array
    {
        return $this->dockerClient->system
            ->info()
            ->result();
    }

}