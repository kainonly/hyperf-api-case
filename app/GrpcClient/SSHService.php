<?php
declare (strict_types=1);

namespace App\GrpcClient;

use Hyperf\GrpcClient\BaseClient;
use SSHMicroservice\AllResponse;
use SSHMicroservice\DeleteParameter;
use SSHMicroservice\ExecParameter;
use SSHMicroservice\ExecResponse;
use SSHMicroservice\GetParameter;
use SSHMicroservice\GetResponse;
use SSHMicroservice\ListsParameter;
use SSHMicroservice\ListsResponse;
use SSHMicroservice\NoParameter;
use SSHMicroservice\PutParameter;
use SSHMicroservice\Response;
use SSHMicroservice\TestingParameter;
use SSHMicroservice\TunnelOption;
use SSHMicroservice\TunnelsParameter;

class SSHService extends BaseClient implements SSHServiceInterface
{
    /**
     * @param string $host
     * @param int $port
     * @param string $username
     * @param string|null $password
     * @param string|null $private_key
     * @param string|null $passphrase
     * @return Response
     * @inheritDoc
     */
    public function testing(
        string $host,
        int $port,
        string $username,
        ?string $password,
        ?string $private_key,
        ?string $passphrase
    ): Response
    {
        $param = new TestingParameter();
        $param->setHost($host);
        $param->setPort($port);
        $param->setUsername($username);
        $param->setPassword($password ?? '');
        $param->setPrivateKey($private_key ?? '');
        $param->setPassphrase($passphrase ?? '');
        list($response) = $this->simpleRequest(
            '/SSHMicroservice.Router/Testing',
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
            '/SSHMicroservice.Router/All',
            $param,
            [AllResponse::class, 'decode']
        );
        return $response;
    }

    /**
     * @param string $identity
     * @param string $host
     * @param int $port
     * @param string $username
     * @param string|null $password
     * @param string|null $private_key
     * @param string|null $passphrase
     * @return Response
     * @inheritDoc
     */
    public function put(
        string $identity,
        string $host,
        int $port,
        string $username,
        ?string $password,
        ?string $private_key,
        ?string $passphrase
    ): Response
    {
        $param = new PutParameter();
        $param->setIdentity($identity);
        $param->setHost($host);
        $param->setPort($port);
        $param->setUsername($username);
        $param->setPassword($password ?? '');
        $param->setPrivateKey($private_key ?? '');
        $param->setPassphrase($passphrase ?? '');
        list($response) = $this->simpleRequest(
            '/SSHMicroservice.Router/Put',
            $param,
            [Response::class, 'decode']
        );
        return $response;
    }

    /**
     * @param string $identity
     * @param string $bash
     * @return ExecResponse
     * @inheritDoc
     */
    public function exec(string $identity, string $bash): ExecResponse
    {
        $param = new ExecParameter();
        $param->setIdentity($identity);
        $param->setBash($bash);
        list($response) = $this->simpleRequest(
            '/SSHMicroservice.Router/Exec',
            $param,
            [ExecResponse::class, 'decode']
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
            '/SSHMicroservice.Router/Delete',
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
            '/SSHMicroservice.Router/Get',
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
            '/SSHMicroservice.Router/Lists',
            $param,
            [ListsResponse::class, 'decode']
        );
        return $response;
    }

    /**
     * @param string $src_ip
     * @param int $src_port
     * @param string $dst_ip
     * @param int $dst_port
     * @return TunnelOption
     */
    private function tunnelOption(
        string $src_ip,
        int $src_port,
        string $dst_ip,
        int $dst_port
    ): TunnelOption
    {
        $option = new TunnelOption();
        $option->setSrcIp($src_ip);
        $option->setSrcPort($src_port);
        $option->setDstIp($dst_ip);
        $option->setDstPort($dst_port);
        return $option;
    }

    /**
     * @param string $identity
     * @param array $tunnels
     * @return Response
     * @inheritDoc
     */
    public function tunnels(string $identity, array $tunnels): Response
    {
        $param = new TunnelsParameter();
        $param->setIdentity($identity);
        $tunnelOptions = array_map(fn($v) => $this->tunnelOption(
            $v['src_ip'],
            $v['src_port'],
            $v['dst_ip'],
            $v['dst_port']
        ), $tunnels);
        $param->setTunnels($tunnelOptions);
        list($response) = $this->simpleRequest(
            '/SSHMicroservice.Router/Tunnels',
            $param,
            [Response::class, 'decode']
        );
        return $response;
    }
}