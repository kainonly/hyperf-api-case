<?php
declare(strict_types=1);

namespace App\Client;

use Psr\Http\Message\StreamInterface;
use Qcloud\Cos\Client;

class CosClient
{
    private Client $client;
    private array $options;

    static public function create(): CosClient
    {
        return new CosClient(config('qcloud'));
    }

    public function __construct(array $options)
    {
        $this->options = $options;
        $this->client = new Client([
            'region' => $options['cos']['region'],
            'schema' => 'https',
            'credentials' => [
                'secretId' => $options['credentials']['secret_id'],
                'secretKey' => $options['credentials']['secret_key']
            ]
        ]);
    }

    public function put(string $key, StreamInterface $body)
    {
        return $this->client->upload(
            $this->options['cos']['bucket'],
            $key,
            $body
        );
    }
}