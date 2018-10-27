<?php
// GENERATED CODE -- DO NOT EDIT!

namespace Greeter;

/**
 */
class GreeterClient extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null) {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     * @param \Greeter\SayHelloRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function SayHello(\Greeter\SayHelloRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/greeter.Greeter/SayHello',
        $argument,
        ['\Greeter\SayHelloResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * @param \Greeter\SayDebugRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function SayDebug(\Greeter\SayDebugRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/greeter.Greeter/SayDebug',
        $argument,
        ['\Greeter\SayDebugResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * @param \Greeter\SayRepeatedRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function SayRepeated(\Greeter\SayRepeatedRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/greeter.Greeter/SayRepeated',
        $argument,
        ['\Greeter\SayRepeatedResponse', 'decode'],
        $metadata, $options);
    }

}
