<?php
/**
 * taskwait
 *
 * Created by PhpStorm
 * User: Alex
 * Date: 2021-09-21 01:29
 * E-mail: <276558492@qq.com>
 */
declare(strict_types=1);

$server = new swoole_server('0.0.0.0', 5200);

$server->set([
    'worker_num' => 2,
    'task_worker_num' => 2
]);

$server->on('receive', function ($serv, $fd, $reactorId, $data) {

    // 异步任务投递，并设置超时等待时间为 3 秒钟
    // 执行流程为：
    // 程序会先在这里等待 3 秒，如果 3 秒内有执行结果，那么 $res 会返回 onTask 回调函数的返回结果（为 true 时），则继续往下执行
    // 如果 3 秒内没有执行结果，那么 $res 会返回 false
    // 不管 $res 是返回 false 还是 true，都不会影响到 onTask 回调函数的执行
    $res = $serv->taskwait('task wait data ====> ' . $data, 3);
    var_dump($res);

    echo PHP_EOL;

    echo 'hello Alex!' . PHP_EOL;  // 不会阻塞，会立刻向下执行

});

$server->on('task', function ($serv, $taskId, $srcWorker, $data) {

    sleep(5);  // 模拟耗时任务

    // 接收到了任务
    echo 'task ====> ' . $data . PHP_EOL;

    return 'success';  // 将异步任务处理结果返回出去，以便 onFinish 回调函数可以接收

});

$server->on('finish', function ($serv, $taskId, $data) {
    echo 'finish result ====> ' . $data . PHP_EOL;
});

$server->start();
