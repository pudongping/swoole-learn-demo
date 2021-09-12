<?php
/**
 * 服务端向客户端发送数据或者文件
 *
 * Created by PhpStorm
 * User: Alex
 * Date: 2021-09-12 18:07
 * E-mail: <276558492@qq.com>
 */
declare(strict_types=1);

$server = new swoole_server('0.0.0.0', 5200);

$server->on('receive', function ($serv, $fd, $reactor_id, $data) {

    echo 'receive start ==> fd ==> [ ' . $fd . ' ] ==> reactor_id ==> [ ' . $reactor_id . ' ] ==> receive data ==> [ ' . $data . ' ]' . PHP_EOL;

    $ret = 'hello world : ' . $data;

    // 向客户端发送数据
    $serv->send($fd, $ret);

    // 向客户端发送文件
    $serv->sendfile($fd, 'test.txt');

});

$server->start();
