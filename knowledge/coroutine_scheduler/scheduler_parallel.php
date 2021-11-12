<?php
/**
 * 使用 parallel 创建多协程
 *
 * Created by PhpStorm
 * User: Alex
 * Date: 2021-10-03 11:54
 * E-mail: <276558492@qq.com>
 */
declare(strict_types=1);

$scheduler = new Co\Scheduler;

// 创建 2 个协程
$scheduler->parallel(2, function () {
    Co::sleep(3);
    echo '1111' . PHP_EOL;
});

$scheduler->start();
