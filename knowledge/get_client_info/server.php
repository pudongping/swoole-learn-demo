<?php
/**
 * 用户上线广播通知
 *
 * Created by PhpStorm
 * User: Alex
 * Date: 2021-09-19 10:35
 * E-mail: <276558492@qq.com>
 */
declare(strict_types=1);

use Swoole\Server;

$server = new swoole_server('0.0.0.0', 5200);

$server->set([
    'worker_num' => 3
]);

$server->on('connect', function ($serv, $fd, $reactor_id) {

    // 获取连接的信息
    $clientInfo = $serv->getClientInfo($fd);
    var_dump($clientInfo);
    echo '===========> ' . PHP_EOL;

    // 用来获取当前 Server 所有的客户端连接
    $allClients = $serv->getClientList();
    var_dump($allClients);
    echo '===========> ' . PHP_EOL;
    // 自己通知自己
    echo 'connect success! ' . PHP_EOL;
    echo '===========> ' . PHP_EOL;

    // 新用户上线，给其他已经上线的用户广播新用户上线状态
    if (! empty($allClients)) {
        $valueKeys = array_flip($allClients);
        if (isset($valueKeys[$fd])) {  // 去掉当前用户的 fd，给其他已上线的用户进行广播
            unset($valueKeys[$fd]);
            foreach ($valueKeys as $oldFd => $val) {
                $serv->send($oldFd, '用户 [ ' . $fd . ' ] 已经上线' . PHP_EOL);
            }
        }
    }

});

$server->on('workerStart', function ($serv, $worker_id) {
    echo 'worker_id ====> [ ' . $worker_id . ' ]' . PHP_EOL;
});

$server->on('receive', function (Server $server, int $fd, int $reactor_id, $data) {
    echo '接收到数据时 receive =====> fd ==> ' . $fd . ' reactor_id ==> ' . $reactor_id . ' data ==> [ ' . $data . ' ]' . PHP_EOL;
});


$server->start();
