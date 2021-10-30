<?php
/**
 * 协程 http 服务器
 *
 * Created by PhpStorm
 * User: Alex
 * Date: 2021-10-03 18:16
 * E-mail: <276558492@qq.com>
 */
declare(strict_types=1);

$scheduler = new Swoole\Coroutine\Scheduler;

$scheduler->add(function () {

    // 必须要在协程的环境下启动
    $http = new Swoole\Coroutine\Http\Server('0.0.0.0', 5200);

    $http->handle('/', function ($request, $response) {
        $response->end('hello coroutine http');
    });

    $http->handle('/alex', function ($request, $response) {
        $response->end('hello alex');
    });

    $http->start();

});


$scheduler->start();
