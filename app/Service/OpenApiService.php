<?php
declare(strict_types=1);

namespace App\Service;

use GuzzleHttp\Client;
use Hyperf\Contract\ConfigInterface;
use Hyperf\Guzzle\ClientFactory;

class OpenApiService
{
    private array $option;
    private Client $client;

    public function __construct(ConfigInterface $config, ClientFactory $clientFactory)
    {
        $this->option = $config->get('qcloud.api');
        $this->client = $clientFactory->create([
            'base_uri' => $this->option['url'],
            'version' => 2.0,
            'timeout' => 2.0,
        ]);
    }

    public function ip(string $value): array
    {
        $response = $this->client->get('/release/ip', [
            'headers' => [
                'x-token' => $this->option['token']
            ],
            'query' => [
                'ip' => $value
            ],
        ]);
        return json_decode($response->getBody()->getContents(), true);
    }
}