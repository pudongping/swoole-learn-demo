<?php
/**
 * 心跳检测
 *
 * Created by PhpStorm
 * User: Alex
 * Date: 2021-10-01 21:37
 * E-mail: <276558492@qq.com>
 */
declare(strict_types=1);

$server = new swoole_server('0.0.0.0', 5200);

// 表示每 5s 遍历一次，一个连接如果 15s 内未向服务器发送任何数据，那么此连接将被强制关闭
$server->set([
    'heartbeat_idle_time' => 15,
    'heartbeat_check_interval' => 5,  // 每 5s 做一次心跳检测（轮询所有的客户端连接）
]);

$server->on('receive', function ($serv, $fd, $reactorId, $data) {


});

$server->start();
