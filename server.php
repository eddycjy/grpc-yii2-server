<?php
/**
 * Created by PhpStorm.
 * User: eddycjy
 * Date: 17/10/18
 * Time: 上午12:20
 */

require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/vendor/yiisoft/yii2/Yii.php';

defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_ENV') or define('YII_ENV', 'dev');
defined('SWOOLE_CLOSE_KEYWORD') or define('SWOOLE_CLOSE_KEYWORD', '>>>SWOOLE|CLOSE<<<');

try {
    $config = require __DIR__ . '/app/config/web.php';
    $app = new yii\web\Application($config);
    $dispatcher = new \mri\core\Dispatcher();
    $router = new \mri\core\grpc\Router();
    $header = new \mri\core\grpc\Header();
} catch (Exception $e) {
    echo 'Caught exception: ', $e->getMessage();
    exit();
}

$http = new swoole_http_server('127.0.0.1', 50051, SWOOLE_PROCESS);
$http->set([
    'log_level' => SWOOLE_LOG_INFO,
    'trace_flags' => 0,
    'worker_num' => 1,
    'open_http2_protocol' => true,
]);

$http->on('request', function (swoole_http_request $request, swoole_http_response $response) use ($app, $dispatcher, $header, $router) {
    $header->setResponse($response)->init();
    try {
        if (trim($request->server['request_uri']) == SWOOLE_CLOSE_KEYWORD) {
            $response->end();
            return;
        }

        $route = $router->setURI($request->server['request_uri'])->route();
        if (is_null($route)) {
            $errorMessage = "Unknown router, request_uri: " . $request->server['request_uri'];
            $header->status(Grpc\STATUS_UNKNOWN, $errorMessage)->getResponse()->end();
            return;
        }

        $app->runAction(
            $route['controller'] . '/' . $route['action'],
            ['request' => $dispatcher->handleRequest($route['controller'], $route['action'], $request->rawcontent())]
        );

        $status = $app->getResponse()->data['status'] ?? Grpc\STATUS_OK;
        $message = $app->getResponse()->data['message'] ?? '';
        $header->status($status, $message)->getResponse()->end(
            $dispatcher->handleResponse($app->getResponse()->data['data'] ?? [])
        );
    } catch (Exception $e) {
        $header->status(Grpc\STATUS_INTERNAL, $e->getMessage())->getResponse()->end();
        return;
    }
});

$http->start();