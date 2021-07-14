<?php
/**
 * 修改进程名称，以及打印出进程 pid
 * swoole version: 4.6.3
 */
use Swoole\Server;

// 第三个参数是运行的模式 SWOOLE_PROCESS 表示多进程模式（默认） SWOOLE_BASE 基础模式
// 第四个参数是 socket 的类型 SWOOLE_SOCK_TCP （默认）
$server = new Swoole\Server('0.0.0.0', 5200, SWOOLE_PROCESS, SWOOLE_SOCK_TCP);

$setting = [
    'worker_num' => 6,  // 开启 6 个 worker 进程
    'reactor_num' => 4,  // 开启 4 个线程
    'task_worker_num' => 3,  // 开启 3 个 task 进程
    // 'max_request' => 5,  // 最大请求数
];

$server->set($setting);

// 启动后在主进程（master）的主线程回调此函数
// onStart 回调中，仅允许 echo、打印 log、修改进程名称，不得执行其他操作
$server->on('start', function (Server $serv) {
    swoole_set_process_name('php:swoole:master');  // 修改主进程的名称
    echo 'master_pid =====> ' . $serv->master_pid . PHP_EOL;
    echo 'manager_pid =====> ' . $serv->manager_pid . PHP_EOL;
});

// onStart 和 onWorkerStart 回调是在不同进程中并行执行的，不存在先后顺序
// 此事件在 worker 进程和 task 进程启动时发生
$server->on('workerstart', function (Server $serv, int $worker_id) {

    if ($serv->taskworker) {
        swoole_set_process_name('php:swoole:task');  // 修改 task 进程的名称
        echo 'task_pid ======> ' . $serv->worker_pid . ' =====> task_id ======> ' . $serv->worker_id . PHP_EOL;
    } else {
        swoole_set_process_name('php:swoole:work');  // 修改 work 进程的名称
        echo 'worker_pid =====> ' . $serv->worker_pid . ' =====> worker_id =====> ' . $serv->worker_id . PHP_EOL;
    }

});

// onManagerStart 在管理进程启动时调用
$server->on('managerstart', function (Server $serv) {
    swoole_set_process_name('php:swoole:manager');  // 修改管理进程的名称
});

// 当 worker 和 task 进程发生异常后会在 manager 进程中回调此函数，此函数主要用于报警和监控
// $worker_id 是异常进程的编号
// $worker_pid 是异常进程的 id
// $exit_code 退出的状态码，范围是 0 ～ 255
// $signal 进程退出的信号
$server->on('workerError', function (Server $serv, int $worker_id, int $worker_pid, int $exit_code, int $signal) {
    // 比如 kill -9 1068 （1068 为某一个 worker 或者 task 进程的 pid）
    // worker error =====> worker_id ==> 6 pid ==> 1068 code ==> 0 signal ==> 9 task_pid ======> 1077 =====> task_id ======> 6
    echo 'worker error =====> worker_id ==> ' . $worker_id . ' pid ==> ' . $worker_pid . ' code ==> ' . $exit_code . ' signal ==> ' . $signal . PHP_EOL;
});

// 进程正常退出时触发，或者当请求数达到了设置的 max_request 数时触发
$server->on('workerStop', function (Server $serv, int $worker_id) {
    // 比如 kill -15 1134 （1134 为某一个 worker 进程的 pid）
    // worker stop =====> worker_id ==> 0
    echo 'worker stop =====> worker_id ==> ' . $worker_id . PHP_EOL;
});

// 设置了 task_worker_num 时，就必须要设置 onTask 和 onFinish 方法
$server->on('task', function (Server $server, int $task_id, int $src_worker_id, mixed $data) {
    echo 'task =====> task_id ==> ' . $task_id . ' src_worker_id ==> ' . $src_worker_id . PHP_EOL;
    echo 'task start';
});

// $fd 为文件描述符
// $reactor_id 为线程 id
$server->on('connect', function (Server $server, int $fd, int $reactor_id) {
    echo 'connect =====> fd ==> ' . $fd . ' reactor_id ==> ' . $reactor_id . PHP_EOL;
    var_dump($server->stats());
});

// 接收到数据时回调 receive 函数
// $fd 为 TCP 客户端连接的唯一标识符
// $reactor_id TCP 连接所在的线程 id
$server->on('receive', function (Server $server, int $fd, int $reactor_id, $data) {
    echo '接收到数据时 receive =====> fd ==> ' . $fd . ' reactor_id ==> ' . $reactor_id . ' data ==> [ ' . $data . ' ]' . PHP_EOL;
});

$server->on('close', function (Server $server, int $fd, int $reactor_id) {
    echo '客户端连接关闭 close =====> fd ==> ' . $fd . ' reactor_id ==> ' . $reactor_id . PHP_EOL;
});

// 启动服务器
$server->start();