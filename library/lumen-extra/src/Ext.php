<?php

namespace lumen\extra;

use Ramsey\Uuid\Uuid;

final class Ext
{
    /**
     * msgpack pack
     * @param array $array
     * @return mixed
     */
    public static function pack(array $array)
    {
        return msgpack_pack($array);
    }

    /**
     * msgpack unpack
     * @param $byte
     * @return array
     */
    public static function unpack($byte)
    {
        return msgpack_unpack($byte);
    }

    /**
     * Factory UUID
     * @param string $version
     * @return string|null
     */
    public static function uuid($version = 'v4', $namespace = null, $name = null)
    {
        try {
            switch ($version) {
                case 'v1':
                    return Uuid::uuid1()->toString();
                case 'v3':
                    if (empty($namespace) || empty($name)) return null;
                    return Uuid::uuid3($namespace, $name)->toString();
                case 'v4':
                    return Uuid::uuid4()->toString();
                case 'v5':
                    if (empty($namespace) || empty($name)) return null;
                    return Uuid::uuid5($namespace, $name)->toString();
                default:
                    return null;
            }
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * Factory order Number
     * @param string $serviceCode length:2
     * @param string $productCode length:3
     * @param string $userCode length:4
     * @return string
     */
    public static function orderNumber($serviceCode, $productCode, $userCode)
    {
        return $serviceCode . rand(0, 9) . $productCode . time() . rand(0, 99) . $userCode;
    }

    /**
     * random code
     * @return string
     */
    public static function random()
    {
        return \ShortCode\Random::get(16);
    }

    /**
     * random short code
     * @return string
     */
    public static function randomShort()
    {
        return \ShortCode\Random::get(8);
    }
}
