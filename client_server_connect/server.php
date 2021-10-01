<?php
/**
 * swoole 服务端
 *
 * Created by PhpStorm
 * User: Alex
 * Date: 2021-10-01 21:56
 * E-mail: <276558492@qq.com>
 */
declare(strict_types=1);

$server = new swoole_server('0.0.0.0', 5200);

$server->on('connect', function () {
    echo 'connected success!' . PHP_EOL;
});

$server->on('receive', function ($serv, $fd, $reactorId, $data) {

    echo 'this is server ====> fd [ ' . $fd . ' ] ==> message [ ' . $data . ' ]' . PHP_EOL;

    $serv->send($fd, '我收到消息了');

});

$server->start();
