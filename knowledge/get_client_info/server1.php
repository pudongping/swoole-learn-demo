<?php
/**
 * 用户的 user_id 和 fd 进行绑定
 *
 * Created by PhpStorm
 * User: Alex
 * Date: 2021-09-19 11:53
 * E-mail: <276558492@qq.com>
 */
declare(strict_types=1);

use Swoole\Server;

$server = new swoole_server('0.0.0.0', 5200);

$server->set([
    'worker_num' => 3
]);

$server->on('connect', function ($serv, $fd, $reactor_id) {

    // 假设随机生成一个用户的用户 id
    $uid = mt_rand(100, 999);
    // 将用户的 uid 和文件描述符进行绑定
    $serv->bind($fd, $uid);
    // 查看绑定结果
    var_dump($serv->getClientInfo($fd));

});

$server->on('workerStart', function ($serv, $worker_id) {
    echo 'worker_id ====> [ ' . $worker_id . ' ]' . PHP_EOL;
});

$server->on('receive', function (Server $server, int $fd, int $reactor_id, $data) {
    echo '接收到数据时 receive =====> fd ==> ' . $fd . ' reactor_id ==> ' . $reactor_id . ' data ==> [ ' . $data . ' ]' . PHP_EOL;
});


$server->start();
