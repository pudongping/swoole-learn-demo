<?php
/**
 * 启动一个协程 server
 *
 * Created by PhpStorm
 * User: Alex
 * Date: 2021-10-03 14:40
 * E-mail: <276558492@qq.com>
 */
declare(strict_types=1);

$scheduler = new Swoole\Coroutine\Scheduler;

$scheduler->add(function () {

    // 必须要在协程的环境下启动
    $coroutineServer = new Swoole\Coroutine\Server('0.0.0.0', 5200);

    $coroutineServer->handle(function ($conn) {

        while (true) {
            echo '从客户端发来的消息 ====> ' . $conn->recv();

            $conn->send('发送消息啦');
        }

    });

    $coroutineServer->start();

});


$scheduler->start();
