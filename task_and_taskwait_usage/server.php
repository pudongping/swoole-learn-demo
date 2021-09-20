<?php
/**
 *
 *
 * Created by PhpStorm
 * User: Alex
 * Date: 2021-09-19 12:24
 * E-mail: <276558492@qq.com>
 */
declare(strict_types=1);

$server = new swoole_server('0.0.0.0', 5200);

$server->on('receive', function ($serv, $fd, $reactor) {});
