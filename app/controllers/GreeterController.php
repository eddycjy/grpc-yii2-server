<?php
/**
 * Created by PhpStorm.
 * User: eddycjy
 * Date: 17/10/18
 * Time: 下午9:58
 */

namespace app\controllers;

use Yii;
use Grpc;
use yii\web\Controller;
use Greeter\SayDebugRequest;
use Greeter\SayHelloRequest;
use Greeter\SayHelloResponse;
use Greeter\SayDebugResponse;
use Greeter\SayRepeatedRequest;
use Greeter\SayRepeatedResponse;
use Greeter\Values;

class GreeterController extends Controller
{
    public function actionSayHello(SayHelloRequest $request)
    {
        $data = new SayHelloResponse();
        $data->setKey($request->getKey());
        $data->setValue($request->getValue());

        Yii::$app->response->data = [
            'status' => Grpc\STATUS_OK,
            'message' => '',
            'data' => $data,
        ];
        return;
    }

    public function actionSayDebug(SayDebugRequest $request)
    {
        $data = new SayDebugResponse();
        $data->setKey($request->getKey());

        $values = [];
        for ($i = 0; $i < 4; $i ++) {
            $value = new Values();
            $value->setKey("test");
            $value->setValueString((string)$request->getValue());
            $value->setValueInt64(1);
            $values[$i] = $value->setValueInt32(1);
        }
        $data->setValues($values);

        Yii::$app->response->data = [
            'status' => Grpc\STATUS_OK,
            'message' => '',
            'data' => $data,
        ];
        return;
    }

    public function actionSayRepeated(SayRepeatedRequest $request)
    {
        $data = new SayRepeatedResponse();
        $data->setKey($request->getKey());
        $data->setValueInt64(1);

        Yii::$app->response->data = [
            'status' => Grpc\STATUS_OK,
            'message' => '',
            'data' => $data,
        ];
        return;
    }
}

