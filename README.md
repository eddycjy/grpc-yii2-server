# grpc-yii2-server

Swoole + Protobuf + Yii2 搭建一个 PHP gRPC Server

## 环境说明

### 环境要求

- PHP >= 7.1 （建议 7.2）
- OpenSSL 1.0.2p

### PHP 扩展

- Swoole 4.2.4（开启 nghttp2、openssl 选项）
- gRPC
- Protobuf
- OpenSSL

建议通过 pecl 安装，方便快捷省心

### 涉及工具

- Protobuf v3.6.1
- PHP Protoc Plugin（grpc_php_plugin）
- Composer

## 使用说明

### 目录结构

```
grpc-yii2-server
├── app
│   ├── common
│   ├── config
│   ├── controllers
│   ├── models
│   └── ...
├── client
├── composer.json
├── composer.lock
├── proto
├── vendor
└── server.php
```

- app：Yii2 应用框架目录
- client：gRPC PHP Client Demo
- proto：proto 最终生成、输出的地方
- vendor：第三方依赖包
- server.php：服务端启动文件

### 生成 Proto 文件

```
$ protoc -I=.  --php_out=./proto/ --grpc_out=./proto/  --plugin=protoc-gen-grpc=/usr/local/bin/grpc_php_plugin ./proto/*.proto
```

### 启动服务

```
$ composer install
$ php server.php
```

### 执行客户端

```
$ php SayHelloClient.php 
Greeter\SayHelloResponse Object
stdClass Object
(
    [metadata] => Array
        (
        )

    [code] => 0
    [details] => 
)
```

### Message 命名约束

- 入参：{action}Request

入参后缀必须为 Request，便于直接解码映射入框架内。默认传入 Yii2 action 的第一个参数，参数名为 $request

### 方法映射

Yii2 Controller 和 Action 映射为 Protobuf 中的 Service 和 RPC 方法

## 例子

### 服务端

- [Greeter.proto](https://github.com/EDDYCJY/grpc-yii2-server/blob/master/proto/Greeter.proto)
- [GreeterController](https://github.com/EDDYCJY/grpc-yii2-server/blob/master/app/controllers/GreeterController.php)

### 客户端

- [Client](https://github.com/EDDYCJY/grpc-yii2-server/tree/master/client)


## 感谢

- [swoole/grpc-client](https://github.com/swoole/grpc-client)