<?php
/**
 * 并发执行 task 并进行协程调度
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
    // 因为总共设置的超时时间是 5 秒，然而协程执行的时候会在第一个任务中消耗 3 秒
    // 第二个任务也消耗 3 秒，因此第三个任务就直接会执行失败
    $res = $serv->taskCo([1, 2, 3], 5);

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
