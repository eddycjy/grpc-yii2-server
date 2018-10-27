<?php
/**
 * Created by PhpStorm.
 * User: eddycjy
 * Date: 24/10/18
 * Time: 下午3:32
 */

use Greeter\GreeterClient;
use Greeter\SayRepeatedRequest;
use Greeter\Values;

require __DIR__ . '/../vendor/autoload.php';

$greeterClient = new GreeterClient('127.0.0.1:50051', [
    'credentials' => Grpc\ChannelCredentials::createInsecure(),
]);

$values = [];
for ($i = 0; $i < 6; $i ++) {
    $object = new Values();
    $object->setKey("say-values-key" . $i);
    $object->setValueInt32($i);
    $object->setValueInt64($i);
    $object->setValueString("say-repeated");
    $values[$i] = $object;
}

$request = new SayRepeatedRequest();
$request->setKey("say-repeated");
$request->setValues($values);

list($reply, $status) = $greeterClient->SayRepeated($request)->wait();

print_r($reply);
print_r($status);