<?php
/**
 * 协程版 redis
 *
 * Created by PhpStorm
 * User: Alex
 * Date: 2021-10-03 19:02
 * E-mail: <276558492@qq.com>
 */
declare(strict_types=1);

$scheduler = new Swoole\Coroutine\Scheduler;

$scheduler->add(function () {

    $redis = new Swoole\Coroutine\Redis();
    $redis->connect('172.28.0.2', 6379);

    $redis->set('name', 'alex');

    $res = $redis->get('name');

    var_dump($res);

});


$scheduler->start();
