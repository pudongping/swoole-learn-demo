<?php
/**
 * 弹幕 websocket 服务端
 *
 * Created by PhpStorm
 * User: Alex
 * Date: 2021-10-04 03:13
 * E-mail: <276558492@qq.com>
 */
declare(strict_types=1);

$ws = new Swoole\Websocket\Server('0.0.0.0', 5200);

$ws->on('open', function ($server, $req) {
    echo "connection open: {$req->fd}" . PHP_EOL;
});

$ws->on('message', function ($server, $frame) {

    $msg = $frame->data;
    echo 'receive: ' . $msg . PHP_EOL;

    // 给所有人广播消息
    foreach ($server->connections as $fd) {
        if ($fd == $frame->fd) {
            continue;
        }
        $server->push($fd, $msg);
    }

});

$ws->start();
