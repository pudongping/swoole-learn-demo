<?php
/**
 * 多协程开启以及传参
 *
 * Created by PhpStorm
 * User: Alex
 * Date: 2021-10-03 11:45
 * E-mail: <276558492@qq.com>
 */
declare(strict_types=1);

$a = 1;

$scheduler = new Co\Scheduler;

// 协程方法传参
$scheduler->add(function ($b) {
    Co::sleep(2);
    echo $b . ' 1111' . PHP_EOL;
}, $a);


// 创建多个协程就多来几次 add
$scheduler->add(function ($b) {
    echo $b . ' 2222' . PHP_EOL;
}, $a);

$scheduler->start();
