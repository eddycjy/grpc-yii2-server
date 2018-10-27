<?php
/**
 * Created by PhpStorm.
 * User: eddycjy
 * Date: 24/10/18
 * Time: 下午3:29
 */

use Greeter\GreeterClient;
use Greeter\SayDebugRequest;

require __DIR__ . '/../vendor/autoload.php';

$greeterClient = new GreeterClient('127.0.0.1:50051', [
    'credentials' => Grpc\ChannelCredentials::createInsecure(),
]);

$request = new SayDebugRequest();
$request->setKey("say-debug");
$request->setValue(2);

list($reply, $status) = $greeterClient->SayDebug($request)->wait();

print_r($reply);
print_r($status);