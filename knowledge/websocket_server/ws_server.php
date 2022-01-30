<?php
/**
 * websocket 服务器
 *
 * Created by PhpStorm
 * User: Alex
 * Date: 2021-10-02 12:25
 * E-mail: <276558492@qq.com>
 */
declare(strict_types=1);

$socket = new swoole_websocket_server('0.0.0.0', 5200);

$socket->on('open', function ($serv, $request) {
    $serv->push($request->fd, 'hello, connected server success');
});

$socket->on('message', function ($serv, $frame) {

    echo '服务端收到了客户端发来的消息 ====> ' . $frame->data . PHP_EOL;

    $serv->push($frame->fd, 'hello client web');

    echo '关闭连接前，连接是否还存在 ====> ' . PHP_EOL;
    var_dump($serv->exist($frame->fd));

    // 主动关闭客户端连接
    $serv->disconnect($frame->fd);

    echo '关闭连接后，连接是否还存在 ====> ' . PHP_EOL;
    var_dump($serv->exist($frame->fd));


});

$socket->start();
