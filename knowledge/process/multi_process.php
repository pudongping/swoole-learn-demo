<?php
/**
 * 多进程的实现
 *
 * Created by PhpStorm
 * User: Alex
 * Date: 2021-10-03 00:58
 * E-mail: <276558492@qq.com>
 */
declare(strict_types=1);

use Swoole\Process;

for ($i = 0; $i < 10; $i++) {

    $process = new Process(function ($pro) use ($i) {

        // 修改子进程的名称
        $pro->name('child_process:php');

        echo $i . ' th process ====> child pid ====> ' . $pro->pid . PHP_EOL;

        sleep(10);

        // 执行完毕之后需要退出当前的子进程
        $pro->exit();

    }, false);

    $childPid = $process->start();
    echo '子进程的 pid 为 ====> ' . $childPid . PHP_EOL;

    // 修改父进程的名称
    $process->name('parent_process:php');

}

// 回收子进程的资源，防止僵死进程的出现
for ($i = 0; $i < 10; $i++) {
    Process::wait();
}
