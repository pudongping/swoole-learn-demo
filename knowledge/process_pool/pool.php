<?php
/**
 * 基于 Process\Pool 通过进程池实现数据库和 Redis 的持久连接
 *
 * Created by PhpStorm
 * User: Alex
 * Date: 2021-10-04 22:13
 * E-mail: <276558492@qq.com>
 */
declare(strict_types=1);

$workerNum = 5;
$pool = new Swoole\Process\Pool($workerNum);

$pool->on("WorkerStart", function ($pool, $workerId) {
    echo "Worker#{$workerId} is started\n";
    $redis = new Redis();  // 这里需要已经安装了 phpredis 扩展
    $redis->pconnect('172.28.0.2', 6379);
    $key = "key1";
    while (true) {
        $msgs = $redis->brpop($key, 2);
        if ($msgs == null) {
            continue;
        }
        var_dump($msgs);
        echo "Processed by Worker#{$workerId}\n";
    }
});

$pool->on("WorkerStop", function ($pool, $workerId) {
    echo "Worker#{$workerId} is stopped\n";
});

$pool->start();
