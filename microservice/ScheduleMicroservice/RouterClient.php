<?php
// GENERATED CODE -- DO NOT EDIT!

namespace ScheduleMicroservice;

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
     * @param \ScheduleMicroservice\GetParameter $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function Get(\ScheduleMicroservice\GetParameter $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/ScheduleMicroservice.Router/Get',
        $argument,
        ['\ScheduleMicroservice\GetResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * @param \ScheduleMicroservice\ListsParameter $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function Lists(\ScheduleMicroservice\ListsParameter $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/ScheduleMicroservice.Router/Lists',
        $argument,
        ['\ScheduleMicroservice\ListsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * @param \ScheduleMicroservice\NoParameter $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function All(\ScheduleMicroservice\NoParameter $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/ScheduleMicroservice.Router/All',
        $argument,
        ['\ScheduleMicroservice\AllResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * @param \ScheduleMicroservice\PutParameter $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function Put(\ScheduleMicroservice\PutParameter $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/ScheduleMicroservice.Router/Put',
        $argument,
        ['\ScheduleMicroservice\Response', 'decode'],
        $metadata, $options);
    }

    /**
     * @param \ScheduleMicroservice\DeleteParameter $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function Delete(\ScheduleMicroservice\DeleteParameter $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/ScheduleMicroservice.Router/Delete',
        $argument,
        ['\ScheduleMicroservice\Response', 'decode'],
        $metadata, $options);
    }

    /**
     * @param \ScheduleMicroservice\RunningParameter $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function Running(\ScheduleMicroservice\RunningParameter $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/ScheduleMicroservice.Router/Running',
        $argument,
        ['\ScheduleMicroservice\Response', 'decode'],
        $metadata, $options);
    }

}
