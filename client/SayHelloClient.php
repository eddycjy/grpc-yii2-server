<?php
/**
 * Created by PhpStorm.
 * User: eddycjy
 * Date: 24/10/18
 * Time: 下午3:26
 */

use Greeter\GreeterClient;
use Greeter\SayHelloRequest;

require __DIR__ . '/../vendor/autoload.php';

$greeterClient = new GreeterClient('127.0.0.1:50051', [
    'credentials' => Grpc\ChannelCredentials::createInsecure(),
]);

$request = new SayHelloRequest();
$request->setKey("say-hello");
$request->setValue(1);

list($reply, $status) = $greeterClient->SayHello($request)->wait();

print_r($reply);
print_r($status);