<?php
/**
 *
 *
 * Created by PhpStorm
 * User: Alex
 * Date: 2021-10-01 19:52
 * E-mail: <276558492@qq.com>
 */
declare(strict_types=1);

$server = new swoole_server('0.0.0.0', 5200);

$server->set([
    'worker_num' => 2,
    'task_worker_num' => 2
]);

$server->on('receive', function ($serv, $fd, $reactorId, $data) {

    // 投递任务到 task 进程中
    $serv->task('task data ====> ' . $data);

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
