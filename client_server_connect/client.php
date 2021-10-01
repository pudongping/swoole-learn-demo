<?php
/**
 * swoole 客户端
 *
 * Created by PhpStorm
 * User: Alex
 * Date: 2021-10-01 21:56
 * E-mail: <276558492@qq.com>
 */
declare(strict_types=1);

// 短连接
for ($i = 0; $i < 5; $i++) {

    $client = new swoole_client(SWOOLE_SOCK_TCP, SWOOLE_SOCK_SYNC);

    $client->connect('127.0.0.1', 5200);

    $client->send('hello, I am client');

    echo $client->recv() . '_1111' . PHP_EOL;

    $client->close();

    sleep(2);

}


// 长连接
/*for ($i = 0; $i < 5; $i++) {

    $client = new swoole_client(SWOOLE_SOCK_TCP | SWOOLE_KEEP, SWOOLE_SOCK_SYNC);

    $client->connect('127.0.0.1', 5200);

    $client->send('hello, I am client');

    echo $client->recv() . '_1111' . PHP_EOL;

    $client->close();

    sleep(2);

}*/
