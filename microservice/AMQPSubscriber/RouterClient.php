<?php
// GENERATED CODE -- DO NOT EDIT!

namespace AMQPSubscriber;

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
     * @param \AMQPSubscriber\PutParameter $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function Put(\AMQPSubscriber\PutParameter $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/AMQPSubscriber.Router/Put',
        $argument,
        ['\AMQPSubscriber\Response', 'decode'],
        $metadata, $options);
    }

    /**
     * @param \AMQPSubscriber\DeleteParameter $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function Delete(\AMQPSubscriber\DeleteParameter $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/AMQPSubscriber.Router/Delete',
        $argument,
        ['\AMQPSubscriber\Response', 'decode'],
        $metadata, $options);
    }

    /**
     * @param \AMQPSubscriber\GetParameter $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function Get(\AMQPSubscriber\GetParameter $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/AMQPSubscriber.Router/Get',
        $argument,
        ['\AMQPSubscriber\GetResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * @param \AMQPSubscriber\ListsParameter $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function Lists(\AMQPSubscriber\ListsParameter $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/AMQPSubscriber.Router/Lists',
        $argument,
        ['\AMQPSubscriber\ListsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * @param \AMQPSubscriber\NoParameter $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function All(\AMQPSubscriber\NoParameter $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/AMQPSubscriber.Router/All',
        $argument,
        ['\AMQPSubscriber\AllResponse', 'decode'],
        $metadata, $options);
    }

}
