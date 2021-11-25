<?php
/**
 *
 *
 * Created by PhpStorm
 * User: Alex
 * Date: 2021-10-02 23:39
 * E-mail: <276558492@qq.com>
 */
declare(strict_types=1);

use Swoole\Process;

// 有标准输出
$process = new Process(function ($pro) {
    // echo 'hello world' . PHP_EOL;
    echo 'hello world';

    // 执行外部脚本
    $pro->exec('/usr/bin/php', ['/home/www/hello.php']);

}, false);

$process->start();

Process::wait();
