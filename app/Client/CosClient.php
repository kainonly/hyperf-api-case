<?php
declare(strict_types=1);

namespace App\Client;

use Carbon\Carbon;
use Exception;
use GuzzleHttp\Psr7\Response;
use Overtrue\CosClient\ObjectClient;

class CosClient
{
    private array $option;

    public function __construct()
    {
        $this->option = config('qcloud');
    }

    /**
     * @param $file
     * @return string
     * @throws Exception
     */
    public function put($file): string
    {
        $fileName = date('Ymd') . '/' .
            uuid()->toString() . '.' .
            $file->getOriginalExtension();
        $object = new ObjectClient([
            'app_id' => $this->option['app_id'],
            'secret_id' => $this->option['secret_id'],
            'secret_key' => $this->option['secret_key'],
            'bucket' => $this->option['cos']['bucket'],
            'region' => $this->option['cos']['region'],
        ]);
        $object->putObject(
            $fileName,
            file_get_contents($file->getRealPath())
        );
        return $fileName;
    }

    /**
     * @param array $objects
     * @return Response
     * @throws Exception
     */
    public function delete(array $objects): Response
    {
        $object = new ObjectClient([
            'app_id' => $this->option['app_id'],
            'secret_id' => $this->option['secret_id'],
            'secret_key' => $this->option['secret_key'],
            'bucket' => $this->option['cos']['bucket'],
            'region' => $this->option['cos']['region'],
        ]);
        return $object->deleteObjects([
            'Delete' => [
                'Quiet' => true,
                'Object' => [...$objects]
            ]
        ]);
    }

    /**
     * 生成客户端上传 COS 对象存储签名
     * @param array $conditions
     * @param int $expired
     * @return array
     * @throws Exception
     */
    public function generatePostPresigned(array $conditions, int $expired = 600): array
    {
        $date = Carbon::now()->setTimezone('UTC');
        $keyTime = $date->unix() . ';' . ($date->unix() + $expired);
        $policy = json_encode([
            'expiration' => $date->addSeconds($expired)->toISOString(),
            'conditions' => [
                ['q-sign-algorithm' => 'sha1'],
                ['q-ak' => $this->option['secret_id']],
                ['q-sign-time' => $keyTime],
                ...$conditions
            ]
        ]);
        $signKey = hash_hmac('sha1', $keyTime, $this->option['secret_key']);
        $stringToSign = sha1($policy);
        $signature = hash_hmac('sha1', $stringToSign, $signKey);
        return [
            'filename' => date('Ymd') . '/' . uuid()->toString(),
            'type' => 'cos',
            'option' => [
                'ak' => $this->option['secret_id'],
                'policy' => base64_encode($policy),
                'key_time' => $keyTime,
                'sign_algorithm' => 'sha1',
                'signature' => $signature
            ],
        ];
    }
}