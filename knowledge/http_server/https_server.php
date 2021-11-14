<?php
/**
 * 对 http 服务增加 ssl 证书
 *
 * Created by PhpStorm
 * User: Alex
 * Date: 2021-10-02 11:23
 * E-mail: <276558492@qq.com>
 */
declare(strict_types=1);

$http = new swoole_http_server('0.0.0.0', 443, SWOOLE_PROCESS, SWOOLE_SOCK_TCP | SWOOLE_SSL);

// 设置证书
$http->set([
    'ssl_cert_file' => __DIR__ . '/config/ssl.crt',
    'ssl_key_file' => __DIR__ . '/config/ssl.key'
]);

$http->on('request', function ($request, $response) {

    if ($request->server['path_info'] == '/favicon.ico' || $request->server['request_uri'] == '/favicon.ico') {
        $response->end();
        return;
    }

    $response->end('hello Alex!' . PHP_EOL);  // 发送 http 响应体，并结束请求处理

});

$http->start();
