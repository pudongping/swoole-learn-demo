<?php
/**
 * 模拟电影票在线选座
 *
 * Created by PhpStorm
 * User: Alex
 * Date: 2021-10-04 00:40
 * E-mail: <276558492@qq.com>
 */
declare(strict_types=1);

$ws = new Swoole\Websocket\Server('0.0.0.0', 5200);  // 启动一个 websocket 服务器

$http = $ws->listen('0.0.0.0', 5201, SWOOLE_SOCK_TCP);  // 重新监听一个端口，启动一个 http 服务器

$http->on('request', function ($request, $response) {  // 这里已经是协程环境下了

    // 接收 post 数据
    $data = $request->post;  // 这里的数据类似于 ==> ['6_4', '6_5', '6_6']

    $redis = new Swoole\Coroutine\Redis;  // 启动协程 redis 必须要在协程环境下

    $redis->connect('127.0.0.1', 6379);

    foreach ($data as $v) {
        // 将已选的座位存入 redis 中
        $redis->lpush('selected_tickets', $v);
    }

});

// ws 连接时触发
$ws->on('open', function ($server, $request) {

    $server->push($request->fd, 'connect success');

});

// ws 发送消息时触发
$ws->on('message', function ($server, $frame) {
    $redis = new Swoole\Coroutine\Redis;  // 启动协程 redis 必须要在协程环境下
    $redis->connect('127.0.0.1', 6379);
    $data = $redis->lrange('selected_tickets', 0, -1);  // 取出列表中所有已经选中的座位
    $data = json_encode($data, 256);

    if ('success' == $frame->data) {  // 如果客户端发送了 'success'
        // 通知所有人，座位已经被选定了
        foreach ($server->connections as $fd) {
            $server->push($fd, $data);
        }
    }

});

$ws->start();
