<?php
declare (strict_types=1);

namespace App\GrpcClient;

use AMQPSubscriber\AllResponse;
use AMQPSubscriber\DeleteParameter;
use AMQPSubscriber\GetParameter;
use AMQPSubscriber\GetResponse;
use AMQPSubscriber\ListsParameter;
use AMQPSubscriber\ListsResponse;
use AMQPSubscriber\NoParameter;
use AMQPSubscriber\PutParameter;
use AMQPSubscriber\Response;
use Hyperf\GrpcClient\BaseClient;

class AMQPSubscriberSubscriberService extends BaseClient implements AMQPSubscriberServiceInterface
{
    /**
     * @param string $identity
     * @param string $queue
     * @param string $url
     * @param string|null $secret
     * @return Response
     * @inheritDoc
     */
    public function put(string $identity, string $queue, string $url, ?string $secret): Response
    {
        $param = new PutParameter();
        $param->setIdentity($identity);
        $param->setQueue($queue);
        $param->setUrl($url);
        $param->setSecret($secret ?? '');
        list($response) = $this->simpleRequest(
            '/AMQPSubscriber.Router/Put',
            $param,
            [Response::class, 'decode']
        );
        return $response;
    }

    /**
     * @return AllResponse
     * @inheritDoc
     */
    public function all(): AllResponse
    {
        $param = new NoParameter();
        list($response) = $this->simpleRequest(
            '/AMQPSubscriber.Router/All',
            $param,
            [AllResponse::class, 'decode']
        );
        return $response;
    }

    /**
     * @param string $identity
     * @return GetResponse
     * @inheritDoc
     */
    public function get(string $identity): GetResponse
    {
        $param = new GetParameter();
        $param->setIdentity($identity);
        list($response) = $this->simpleRequest(
            '/AMQPSubscriber.Router/Get',
            $param,
            [GetResponse::class, 'decode']
        );
        return $response;
    }

    /**
     * @param array $identity
     * @return ListsResponse
     * @inheritDoc
     */
    public function lists(array $identity): ListsResponse
    {
        $param = new ListsParameter();
        $param->setIdentity($identity);
        list($response) = $this->simpleRequest(
            '/AMQPSubscriber.Router/Lists',
            $param,
            [ListsResponse::class, 'decode']
        );
        return $response;
    }

    /**
     * @param string $identity
     * @return Response
     * @inheritDoc
     */
    public function delete(string $identity): Response
    {
        $param = new DeleteParameter();
        $param->setIdentity($identity);
        list($response) = $this->simpleRequest(
            '/AMQPSubscriber.Router/Delete',
            $param,
            [Response::class, 'decode']
        );
        return $response;
    }
}