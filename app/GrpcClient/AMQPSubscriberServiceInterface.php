<?php
declare (strict_types=1);

namespace App\GrpcClient;

use AMQPSubscriber\AllResponse;
use AMQPSubscriber\GetResponse;
use AMQPSubscriber\ListsResponse;
use AMQPSubscriber\Response;

/**
 * Interface AMQPSubscriberServiceInterface
 * @package App\GrpcClient
 * @method bool close($yield = false)
 */
interface AMQPSubscriberServiceInterface
{
    /**
     * @param string $identity
     * @param string $queue
     * @param string $url
     * @param string|null $secret
     * @return Response
     */
    public function put(string $identity, string $queue, string $url, ?string $secret): Response;

    /**
     * @return AllResponse
     */
    public function all(): AllResponse;

    /**
     * @param string $identity
     * @return GetResponse
     */
    public function get(string $identity): GetResponse;

    /**
     * @param array $identity
     * @return ListsResponse
     */
    public function lists(array $identity): ListsResponse;

    /**
     * @param string $identity
     * @return Response
     */
    public function delete(string $identity): Response;
}