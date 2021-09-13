<?php
/**
 * 进程之间数据发送
 *
 * Created by PhpStorm
 * User: Alex
 * Date: 2021-09-12 20:03
 * E-mail: <276558492@qq.com>
 */
declare(strict_types=1);

$server = new swoole_server('0.0.0.0', 5200);

$server->set([
    'worker_num' => 3
]);

$server->on('workerStart', function ($serv, $worker_id) {
    echo 'worker_id ==> [ ' . $worker_id . ' ]' . PHP_EOL;
});

$server->on('pipeMessage', function ($serv, $src_worker, $message) {
    echo 'pipeMessage start ==> 自身的 worker_id ==> [ ' . $serv->worker_id . ' ] 来源于哪个 worker_id ==> [ ' . $src_worker . ' ] 收到的消息内容为 ==> [ ' . $message . ' ]' . PHP_EOL;
});

$server->on('receive', function ($serv, $fd, $reactor_id, $data) {

    echo 'receive start ==> fd ==> [ ' . $fd . ' ] ==> reactor_id ==> [ ' . $reactor_id . ' ] ==> receive data ==> [ ' . $data . ' ]' . PHP_EOL;

    echo 'current worker_id is ==> ' . $serv->worker_id . PHP_EOL;

    // 向其他 worker 进程发送数据
    $serv->sendMessage('hello Alex ', $serv->worker_id + 1);

});

$server->start();
