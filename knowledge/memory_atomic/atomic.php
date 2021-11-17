<?php
/**
 * 进程间无锁计数器 Atomic
 *
 * Created by PhpStorm
 * User: Alex
 * Date: 2021-10-02 02:45
 * E-mail: <276558492@qq.com>
 */
declare(strict_types=1);

// 创建一个原子计数对象
$age = new swoole_atomic(22);

// 增加计数
$age->add(3);

// 减少计数
$age->sub();

// 返回当前值
echo $age->get() . PHP_EOL;

// 将当前值设置为指定的数字
$age->set(18);

echo $age->get() . PHP_EOL;

$age->cmpset(18, 30);

echo $age->get() . PHP_EOL;

