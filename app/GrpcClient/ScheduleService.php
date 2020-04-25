<?php
declare (strict_types=1);

namespace App\GrpcClient;

use Hyperf\GrpcClient\BaseClient;
use ScheduleMicroservice\AllResponse;
use ScheduleMicroservice\DeleteParameter;
use ScheduleMicroservice\EntryOption;
use ScheduleMicroservice\GetParameter;
use ScheduleMicroservice\GetResponse;
use ScheduleMicroservice\ListsParameter;
use ScheduleMicroservice\ListsResponse;
use ScheduleMicroservice\NoParameter;
use ScheduleMicroservice\PutParameter;
use ScheduleMicroservice\Response;
use ScheduleMicroservice\RunningParameter;

class ScheduleService extends BaseClient implements ScheduleServiceInterface
{
    /**
     * @return AllResponse
     * @inheritDoc
     */
    public function all(): AllResponse
    {
        $param = new NoParameter();
        list($response) = $this->simpleRequest(
            '/ScheduleMicroservice.Router/All',
            $param,
            [AllResponse::class, 'decode']
        );
        return $response;
    }

    /**
     * @param string $cron_time
     * @param string $url
     * @param array $headers
     * @param array $body
     * @return EntryOption
     */
    private function entryOption(string $cron_time, string $url, array $headers, array $body): EntryOption
    {
        $option = new EntryOption();
        $option->setCronTime($cron_time);
        $option->setUrl($url);
        $option->setHeaders(json_encode($headers));
        $option->setBody(json_encode($body));
        return $option;
    }

    /**
     * @param string $identity
     * @param string $timezone
     * @param bool $start
     * @param array $entry
     * @return Response
     * @inheritDoc
     */
    public function put(string $identity, string $timezone, bool $start, array $entry): Response
    {
        $param = new PutParameter();
        $param->setIdentity($identity);
        $param->setTimeZone($timezone);
        $param->setStart($start);
        $enties = array_map(fn($v) => $this->entryOption(
            $v['cron_time'],
            $v['url'],
            $v['headers'],
            $v['body']
        ), $entry);
        $param->setEntries($enties);
        list($response) = $this->simpleRequest(
            '/ScheduleMicroservice.Router/Put',
            $param,
            [Response::class, 'decode']
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
            '/ScheduleMicroservice.Router/Get',
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
            '/ScheduleMicroservice.Router/Lists',
            $param,
            [ListsResponse::class, 'decode']
        );
        return $response;
    }

    /**
     * @param string $identity
     * @param bool $running
     * @return Response
     * @inheritDoc
     */
    public function running(string $identity, bool $running): Response
    {
        $param = new RunningParameter();
        $param->setIdentity($identity);
        $param->setRunning($running);
        list($response) = $this->simpleRequest(
            '/ScheduleMicroservice.Router/Running',
            $param,
            [Response::class, 'decode']
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
            '/ScheduleMicroservice.Router/Delete',
            $param,
            [Response::class, 'decode']
        );
        return $response;
    }
}