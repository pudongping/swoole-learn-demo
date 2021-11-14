<?php
/**
 * http 服务器
 *
 * Created by PhpStorm
 * User: Alex
 * Date: 2021-10-02 03:12
 * E-mail: <276558492@qq.com>
 */
declare(strict_types=1);

$http = new swoole_http_server('0.0.0.0', 5200);

// 服务器启动时返回响应
$http->on('start', function ($server) {
    echo 'Swoole http server is started at http://127.0.0.1:5200' . PHP_EOL;
});

$http->on('request', function ($request, $response) {

    if ($request->server['path_info'] == '/favicon.ico' || $request->server['request_uri'] == '/favicon.ico') {
        $response->end();
        return;
    }

    $response->status(404);  // 设置响应 http 状态码
    $response->header("Content-Type", "text/plain");  // 设置响应头
    $response->end('hello Alex!' . PHP_EOL);  // 发送 http 响应体，并结束请求处理

});

// 启动 http 服务器
$http->start();
