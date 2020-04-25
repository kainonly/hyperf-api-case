<?php
declare (strict_types=1);

namespace App\GrpcClient;

use ScheduleMicroservice\AllResponse;
use ScheduleMicroservice\GetResponse;
use ScheduleMicroservice\ListsResponse;
use ScheduleMicroservice\Response;

/**
 * Interface ScheduleServiceInterface
 * @package App\GrpcClient
 * @method bool close($yield = false)
 */
interface ScheduleServiceInterface
{
    /**
     * 获取所有任务标识
     * @return AllResponse
     */
    public function all(): AllResponse;

    /**
     * 新增或修改任务
     * @param string $identity
     * @param string $timezone
     * @param bool $start
     * @param array $entry
     * @return Response
     */
    public function put(string $identity, string $timezone, bool $start, array $entry): Response;

    /**
     * 获取任务信息
     * @param string $identity
     * @return GetResponse
     */
    public function get(string $identity): GetResponse;

    /**
     * 指定获取多个任务信息
     * @param array $identity
     * @return ListsResponse
     */
    public function lists(array $identity): ListsResponse;

    /**
     * 任务运行状态控制
     * @param string $identity
     * @param bool $running
     * @return Response
     */
    public function running(string $identity, bool $running): Response;

    /**
     * 删除任务
     * @param string $identity
     * @return Response
     */
    public function delete(string $identity): Response;
}