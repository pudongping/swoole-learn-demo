<?php
/**
 *
 *
 * Created by PhpStorm
 * User: Alex
 * Date: 2021-10-01 21:02
 * E-mail: <276558492@qq.com>
 */
declare(strict_types=1);

$server = new swoole_server('0.0.0.0', 5200);

$server->on('receive', function ($serv, $fd, $reactorId, $data) {

    // 间隔时钟定时器
    // 每 2000 毫秒便执行一次
    $timerId = \Swoole\Timer::tick(2000, function () {
            echo 'Alex' . PHP_EOL;
        });

    // swoole_timer_tick(2000, function () {
    //     echo 'Alex' . PHP_EOL;
    // });


    // 指定时钟定时器
    swoole_timer_after(3000, function () {
        echo '3000 毫秒后执行一次，便直接结束了' . PHP_EOL;
    });

    // 清除一个定时器
    \Swoole\Timer::after(10000, function () use ($serv, $timerId) {
        echo '10000 毫秒后要被清除定时器了' . PHP_EOL;
        $serv->clearTimer($timerId);
        echo '不会再执行了' . PHP_EOL;
    });

});

$server->start();
