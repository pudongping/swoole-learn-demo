<?php
/**
 * 服务端多端口监听
 *
 * Created by PhpStorm
 * User: Alex
 * Date: 2021-10-01 20:25
 * E-mail: <276558492@qq.com>
 */
declare(strict_types=1);


$server = new swoole_server('0.0.0.0', 9505);

// 新添加一个监听端口
$port = $server->listen('0.0.0.0', 9506, SWOOLE_SOCK_TCP);

// 接收 9506 端口的发送内容
$port->on('receive', function ($serv, $fd, $reactorId, $data) {

    echo '9506 port ====> ' . $data .  PHP_EOL;

});

$server->on('connect', function ($serv, $fd, $reactorId) {

    // 打印连接状态
    // var_dump($serv->stats());

});

$server->on('receive', function ($serv, $fd, $reactorId, $data) {

    echo '9505 port ====> ' . $data .  PHP_EOL;

});


$server->start();
