<?php
// GENERATED CODE -- DO NOT EDIT!

namespace SSHMicroservice;

/**
 */
class RouterClient extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null) {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     * @param \SSHMicroservice\TestingParameter $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function Testing(\SSHMicroservice\TestingParameter $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/SSHMicroservice.Router/Testing',
        $argument,
        ['\SSHMicroservice\Response', 'decode'],
        $metadata, $options);
    }

    /**
     * @param \SSHMicroservice\PutParameter $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function Put(\SSHMicroservice\PutParameter $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/SSHMicroservice.Router/Put',
        $argument,
        ['\SSHMicroservice\Response', 'decode'],
        $metadata, $options);
    }

    /**
     * @param \SSHMicroservice\ExecParameter $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function Exec(\SSHMicroservice\ExecParameter $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/SSHMicroservice.Router/Exec',
        $argument,
        ['\SSHMicroservice\ExecResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * @param \SSHMicroservice\DeleteParameter $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function Delete(\SSHMicroservice\DeleteParameter $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/SSHMicroservice.Router/Delete',
        $argument,
        ['\SSHMicroservice\Response', 'decode'],
        $metadata, $options);
    }

    /**
     * @param \SSHMicroservice\GetParameter $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function Get(\SSHMicroservice\GetParameter $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/SSHMicroservice.Router/Get',
        $argument,
        ['\SSHMicroservice\GetResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * @param \SSHMicroservice\NoParameter $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function All(\SSHMicroservice\NoParameter $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/SSHMicroservice.Router/All',
        $argument,
        ['\SSHMicroservice\AllResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * @param \SSHMicroservice\ListsParameter $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function Lists(\SSHMicroservice\ListsParameter $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/SSHMicroservice.Router/Lists',
        $argument,
        ['\SSHMicroservice\ListsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * @param \SSHMicroservice\TunnelsParameter $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function Tunnels(\SSHMicroservice\TunnelsParameter $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/SSHMicroservice.Router/Tunnels',
        $argument,
        ['\SSHMicroservice\Response', 'decode'],
        $metadata, $options);
    }

}
