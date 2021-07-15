<?php
/**
 * 设置属性并获取属性
 * swoole version: 4.6.3
 */
use Swoole\Server;

$server = new Server('0.0.0.0', 5200, SWOOLE_PROCESS, SWOOLE_SOCK_TCP);

$setting = [
    'worker_num' => 6,  // 开启 6 个 worker 进程
    'reactor_num' => 4,  // 开启 4 个线程
    'task_worker_num' => 3,  // 开启 3 个 task 进程
    // 'max_request' => 5,  // 表示 worker 进程在处理完 5 次请求后结束运行，manager 会重新创建一个 worker 进程。此选项用来防止 worker 进程内存溢出
    // 'max_conn' => 10000,  // 设置允许维持 10000 个 tcp 连接，超过 10000 后，新进入的连接会被拒绝，最大不能超过操作系统的 ulimit -n 的值
    // 'daemonize' => true,  // 作为守护进程运行
    // 'heartbeat_check_interval' => 30,  // 每隔 30 秒检测一次，swoole 会轮询所有 tcp 连接，将超过心跳时间的连接关闭掉
    // 'heartbeat_idle_time' => 60,  // tcp 连接的最大闲置时间，单位秒，如果某 fd 最后一次发包距离现在的时间超过 heartbeat_idle_time 会把这个连接关闭掉
    // 'enable_coroutine' => false,  // 默认为 true，设置为 false ，则关闭掉内置协程
];

$server->set($setting);

$server->on('workerStart', function (Server $serv) {

    // $serv->taskworker 返回 true 表示当前的进程是 task 进程，false 表示当前的进程是 worker 进程
    if ($serv->taskworker) {
        echo 'task_pid ====> ' . $serv->worker_pid . PHP_EOL;
    } else {
        echo 'worker_pid ====> ' . $serv->worker_pid . PHP_EOL;
    }

});

$server->on('task', function () {
    echo 'task start';
});


$server->on('receive', function (Server $serv, int $fd, int $reactor_id, $data) {

    echo '设置项为 ====> ' . var_export($serv->setting, true) . PHP_EOL;

    // 当前服务器主进程的 pid
    echo 'master_pid ====> ' . $serv->master_pid . PHP_EOL;

    // 当前服务器管理进程的 pid
    echo 'manager_pid ====> ' . $serv->manager_pid . PHP_EOL;

    // 当前 worker 进程的 pid
    echo 'worker_pid ====> ' . $serv->worker_pid . PHP_EOL;

    echo '接收到的数据为 ====> ' . var_export($data, true) . PHP_EOL;

    // 当前所有在线的连接
    foreach ($serv->connections as $fd) {
        // fd 为 file description
        echo '当前所有的文件描述符连接 ====> ' . $fd . PHP_EOL;
    }

});

$server->start();
