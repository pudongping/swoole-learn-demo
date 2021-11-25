<?php
/**
 * 子进程和主进程之间通讯
 *
 * Created by PhpStorm
 * User: Alex
 * Date: 2021-10-02 23:49
 * E-mail: <276558492@qq.com>
 */
declare(strict_types=1);

use Swoole\Process;

// 将数据投递到管道中
$process = new Process(function ($pro) {

    // 修改子进程的名称
    $pro->name('child_process:php');

    echo 'child pid ====> ' . $pro->pid . PHP_EOL;
    // 将消息写入管道
    $pro->write('save msg to pipe ' . PHP_EOL);

    sleep(10);

}, true);

$childPid = $process->start();

echo '子进程的 pid 为 ====> ' . $childPid . PHP_EOL;

// 修改父进程的名称
$process->name('parent_process:php');

// 这里读取子进程写入到管道的数据
// 这里的 read 是阻塞的，比如上面子进程中没有 write 数据，那么这里会一直等待
echo 'from pipe ====> ' . $process->read();

Process::wait();
