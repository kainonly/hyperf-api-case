<?php
declare (strict_types=1);

namespace App\GrpcClient;

use SSHMicroservice\AllResponse;
use SSHMicroservice\ExecResponse;
use SSHMicroservice\GetResponse;
use SSHMicroservice\ListsResponse;
use SSHMicroservice\Response;

/**
 * Interface SSHServiceInterface
 * @package App\GrpcClient
 * @method bool close($yield = false)
 */
interface SSHServiceInterface
{
    public function testing(
        string $host,
        int $port,
        string $username,
        ?string $password,
        ?string $private_key,
        ?string $passphrase
    ): Response;

    /**
     * 获取所有SSH连接标识
     * @return AllResponse
     */
    public function all(): AllResponse;

    /**
     * ssh连接新增
     * @param string $identity
     * @param string $host
     * @param int $port
     * @param string $username
     * @param string|null $password
     * @param string|null $private_key
     * @param string|null $passphrase
     * @return Response
     */
    public function put(
        string $identity,
        string $host,
        int $port,
        string $username,
        ?string $password,
        ?string $private_key,
        ?string $passphrase
    ): Response;

    /**
     * ssh远程执行命令
     * @param string $identity
     * @param string $bash
     * @return ExecResponse
     */
    public function exec(string $identity, string $bash): ExecResponse;

    /**
     * 删除ssh连接
     * @param string $identity
     * @return Response
     */
    public function delete(string $identity): Response;

    /**
     * 获取ssh连接
     * @param string $identity
     * @return GetResponse
     */
    public function get(string $identity): GetResponse;

    /**
     * 指定获取ssh连接
     * @param array $identity
     * @return ListsResponse
     */
    public function lists(array $identity): ListsResponse;

    /**
     * 设置SSH隧道
     * @param string $identity
     * @param array $tunnels
     * @return Response
     */
    public function tunnels(string $identity, array $tunnels): Response;
}