<?php
/**
 * 并发执行多个异步任务
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

    // 投递任务到 task 进程中，并设置 5 秒的超时时间
    // 这里会同时去执行异步任务，但是取决于 task_worker_num 的数量
    // 这里模拟了 3 个异步任务同时执行，但是 task_worker_num 只有 2 个
    // 因此前面 2 个异步任务会同时执行，第 3 个任务会被等待
    $res = $serv->taskWaitMulti([1, 2, 3], 5);  // 这里是阻塞的

    var_dump($res);

    echo 'hello Alex!' . PHP_EOL;  // 不会阻塞，会立刻向下执行

});

$server->on('task', function ($serv, $taskId, $srcWorker, $data) {

    sleep(3);  // 模拟耗时任务

    // 接收到了任务
    echo 'task ====> ' . $data . PHP_EOL;

    return 'success' . $data;  // 将异步任务处理结果返回出去，以便 onFinish 回调函数可以接收

});

$server->on('finish', function ($serv, $taskId, $data) {
    echo 'finish result ====> ' . $data . PHP_EOL;
});

$server->start();
