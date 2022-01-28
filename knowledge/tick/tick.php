<?php
/**
 *
 *
 * Created by PhpStorm
 * User: Alex
 * Date: 2021-10-01 20:58
 * E-mail: <276558492@qq.com>
 */
declare(strict_types=1);


$server = new swoole_server('0.0.0.0', 5200);

$server->on('receive', function ($serv, $fd, $reactorId, $data) {

    // 每 2000 毫秒便执行一次
    $serv->tick(2000, function () {
        echo 'Alex' . PHP_EOL;
    });

});

$server->start();
