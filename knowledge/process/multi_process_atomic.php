<?php
/**
 * 多进程之间通过 atomic 数据共享
 *
 * Created by PhpStorm
 * User: Alex
 * Date: 2021-10-03 01:19
 * E-mail: <276558492@qq.com>
 */
declare(strict_types=1);

use Swoole\Process;

// 计数器
// $counter = 0;
$counter = new swoole_atomic(0);

for ($i = 0; $i < 10; $i++) {

    $process = new Process(function ($pro) use ($i, $counter) {

        // 修改子进程的名称
        $pro->name('child_process:php');

        echo $i . ' th process ====> child pid ====> ' . $pro->pid . PHP_EOL;

        // 计数器自增加 1
        // $counter++;
        $counter->add();
        // echo $counter . PHP_EOL;
        echo $counter->get() . PHP_EOL;

        sleep(20);

        // 执行完毕之后需要退出当前的子进程
        $pro->exit();

    }, false);

    $childPid = $process->start();

    // 修改父进程的名称
    $process->name('parent_process:php');

}

// 回收子进程的资源，防止僵死进程的出现
for ($i = 0; $i < 10; $i++) {
    Process::wait();
}

// echo '总数 ====> ' . $counter . PHP_EOL;
echo '总数 ====> ' . $counter->get() . PHP_EOL;
