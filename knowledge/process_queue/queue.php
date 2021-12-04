<?php
/**
 * process 进程消息队列实现进程之间通信
 *
 * Created by PhpStorm
 * User: Alex
 * Date: 2021-10-03 01:32
 * E-mail: <276558492@qq.com>
 */
declare(strict_types=1);

use Swoole\Process;

for ($i = 0; $i < 10; $i++) {

    $process = new Process(function ($pro) {
        // 修改子进程的名称
        $pro->name('child_process:php');

        // 从消息队列中取出数据
        // echo $pro->pop() . PHP_EOL;

        // 也可以从这里 push 进去
        $pro->push('this is children pid ====> ' . $pro->pid);

    }, false);

    $process->useQueue();  // 使用消息队列

    $childPid = $process->start();
    // 修改父进程的名称
    $process->name('parent_process:php');

    $pros[$childPid] = $process;

}


foreach ($pros as $childrenPid => $pro) {

    echo $childrenPid . PHP_EOL;

    // 往队列中推送一条消息
    // $pro->push('this is children pid ====> ' . $childrenPid);

    // 从这里取出
    echo $pro->pop() . PHP_EOL;

    Process::wait();
}
