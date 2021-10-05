<?php
/**
 * 协程之间通讯
 *
 * Created by PhpStorm
 * User: Alex
 * Date: 2021-10-03 14:11
 * E-mail: <276558492@qq.com>
 */
declare(strict_types=1);

$scheduler = new Swoole\Coroutine\Scheduler;

$channel = new Swoole\Coroutine\Channel;

$scheduler->add(function ($chan) {

    // 生产者
    $chan->push([
        'user_name' => 'Alex',
    ]);
    $chan->push([
        'user_name' => 'Harry',
    ]);

}, $channel);


// $scheduler->add(function ($chan) {
//
//     // 消费者
//     $res = $chan->pop();
//     var_dump($res);
//
// }, $channel);


$scheduler->parallel(2, function ($chan) {

    if (! $chan->isEmpty()) {
        var_dump($chan->pop());
    }

}, $channel);


$scheduler->start();
