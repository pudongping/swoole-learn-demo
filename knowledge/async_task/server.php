<?php

$server = new Swoole\Server('0.0.0.0', 5200, SWOOLE_PROCESS, SWOOLE_SOCK_TCP);

$setting = [
    'worker_num' => 6,  // 开启 6 个 worker 进程
    'reactor_num' => 4,  // 开启 4 个线程
    'task_worker_num' => 3,  // 开启 3 个 task 进程
];

$server->set($setting);

$server->on('receive', function ($server, $fd, $reactor_id, $data) {

    // receive start ==> fd ==> [ 1 ] reactor_id ==> [ 0 ] ==> data [ 1234 ]
    echo 'receive start ==> fd ==> [ ' . $fd . ' ] reactor_id ==> [ ' . $reactor_id . ' ] ==> data [ ' . $data . ' ]' . PHP_EOL;

    // 异步投递任务
    $server->task('send mail');

    echo 'login now' . PHP_EOL;


});

// 要开启 task 异步投递，必须要设置 task_worker_num 数
$server->on('task', function ($serv, $task_id, $src_worker_id, $data) {
    sleep(10);
    // task start ==> task_id ==> [ 0 ] ==> src_worker_id ==> [ 4 ] ==> data [ send mail ]
    echo 'task start ==> task_id ==> [ ' . $task_id . ' ] ==> src_worker_id ==> [ ' . $src_worker_id . ' ] ==> data [ ' . $data . ' ]' . PHP_EOL;

    // 可以在这里将处理结果 return 出去，这样在 onFinish 回调函数中就可以接收到 task 最终的处理结果了
    return 'success';
});

$server->on('finish', function ($serv, $task_id, $res) {
    // finish start ==> task_id ==> [ 0 ] ==> res ==> [ success ]
    echo 'finish start ==> task_id ==> [ ' . $task_id . ' ] ==> res ==> [ ' . $res . ' ]';
});

$server->start();
