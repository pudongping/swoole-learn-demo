<?php
/**
 *
 *
 * Created by PhpStorm
 * User: Alex
 * Date: 2021-10-02 03:00
 * E-mail: <276558492@qq.com>
 */
declare(strict_types=1);

// 创建一个原子计数对象
$n = new swoole_atomic();

if (pcntl_fork() > 0) {  // 父进程
    echo "master start\n";
    $n->wait(1.5);  // 当原子计数当值为 0 时，程序进入等待状态
    echo "master end\n";
} else {  // 子进程
    echo "child start\n";
    sleep(1);
    // 唤醒处于 wait 状态的其他进程，实现等待、通知、锁
    // $n->wakeup();  // 如果没有这一行，那么父进程则会等待 1.5s 后才会输出下面的内容
    echo "child end\n";
}
