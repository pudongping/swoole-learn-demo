<?php
/**
 * 协程版 mysql 客户端
 *
 * Created by PhpStorm
 * User: Alex
 * Date: 2021-10-03 19:11
 * E-mail: <276558492@qq.com>
 */
declare(strict_types=1);

$scheduler = new Swoole\Coroutine\Scheduler;

$scheduler->add(function () {

    $mysql = new Swoole\Coroutine\Mysql();

    $config = [
        'host' => '172.28.0.5',
        'port' => 3306,
        'user' => 'root',
        'password' => 'root',
        'database' => 'ubiquitous',
    ];

    $ret1 = $mysql->connect($config);

    // $mysql->query("INSERT INTO `ubiquitous`.`users`(`name`, `email`, `avatar`, `gender`, `password`, `created_at`, `updated_at`) VALUES ('alex', '123456@admin.com', '', 1, 'password', '2021-05-31 06:21:51', '2021-05-31 06:22:34')");

    $stmt = $mysql->prepare('select * from users where name = ? limit ?');

    if ($stmt == false) {
        var_dump($mysql->errno, $mysql->error);
    } else {
        $ret2 = $stmt->execute(['alex', 1]);
        var_dump($ret2);
    }


});


$scheduler->start();
