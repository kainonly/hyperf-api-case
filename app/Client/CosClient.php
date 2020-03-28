<?php
declare(strict_types=1);

namespace App\Client;

use GuzzleHttp\Command\Result;
use Qcloud\Cos\Client;

class CosClient
{
    private Client $client;
    private array $options;

    public function __construct()
    {
        $this->options = config('qcloud');
        $this->client = new Client([
            'region' => $this->options['cos']['region'],
            'schema' => 'https',
            'credentials' => [
                'secretId' => $this->options['credentials']['secret_id'],
                'secretKey' => $this->options['credentials']['secret_key']
            ]
        ]);
    }

    /**
     * @param string $key
     * @param $body
     * @return Result
     */
    public function uploads(string $key, $body): Result
    {
        return $this->client->upload(
            $this->options['cos']['bucket'],
            $key,
            $body
        );
    }
}