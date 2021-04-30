<?php
declare(strict_types=1);

namespace App\Service;

use Carbon\Carbon;
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

    /**
     * 生产签名
     * @param array $header
     * @param string $md5
     * @param string $path
     * @return string
     */
    private function factorySignature(array $header, string $md5, string $path): string
    {
        ksort($header);
        $str = '';
        foreach ($header as $key => $value) {
            $key = strtolower($key);
            if ($key === 'accept') {
                continue;
            }
            $str .= $key . ': ' . $value . "\n";
        }
        $str .= "POST\n";
        $str .= "application/json\n";
        $str .= "application/json\n";
        $str .= $md5 . "\n";
        $str .= $path;
        return base64_encode(hash_hmac('sha1', $str, $this->option['appsecret'], true));
    }

    public function ip2region(string $ip): array
    {
        $headers = [
            'X-Date' => Carbon::now()->toRfc7231String(),
            'Source' => 'apigw ip2region',
            'Accept' => 'application/json'
        ];
        $path = '/ip2region';
        $body = [
            'ip' => $ip
        ];
        $md5 = base64_encode(md5(json_encode($body)));
        $signature = $this->factorySignature($headers, $md5, $path);
        $authorization = 'hmac ';
        $authorization .= 'id="' . $this->option['appkey'] . '", ';
        $authorization .= 'algorithm="hmac-sha1", ';
        $authorization .= 'headers="source x-date", ';
        $authorization .= 'signature="' . $signature . '"';
        $headers['Content-MD5'] = $md5;
        $headers['Authorization'] = $authorization;
        $response = $this->client->post('/release' . $path, [
            'headers' => $headers,
            'json' => $body,
        ]);
        return json_decode($response->getBody()->getContents(), true);
    }
}