<?php
/**
 * swoole 协程的几种创建方式
 *
 * Created by PhpStorm
 * User: Alex
 * Date: 2021-10-03 11:10
 * E-mail: <276558492@qq.com>
 */
declare(strict_types=1);

// co 是 Swoole\Coroutine 的缩写


echo 'start ...' . PHP_EOL;

// 第一种方式：co::create
// Swoole\Coroutine::create(function () {
//
//     co::sleep(2);  // 模拟 io 操作，停止 2s
//     echo 'hello coroutine' . PHP_EOL;
//
// });


// 第二种方式： go 函数。（go 函数是 Co::create 的缩写）
// go(function () {
//
//     co::sleep(2);  // 模拟 io 操作，停止 2s
//     echo 'hello coroutine' . PHP_EOL;
//
// });

// 第三种方式：Scheduler
$scheduler = new Swoole\Coroutine\Scheduler;

$scheduler->add(function () {
    Co::sleep(2);
    echo 'hello coroutine' . PHP_EOL;
});

$scheduler->start();

echo 'end ...' . PHP_EOL;
