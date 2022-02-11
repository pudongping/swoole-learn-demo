<?php
/**
 * 多进程爬虫程序
 *
 * Created by PhpStorm
 * User: Alex
 * Date: 2021-10-03 02:40
 * E-mail: <276558492@qq.com>
 */
declare(strict_types=1);

use Swoole\Process;
use Swoole\Atomic;

$counter = new Atomic();
$startTime = time();
$workerNum = 5;

for ($i = 0; $i < $workerNum; $i++) {

    $process = new Process(function ($pro) use ($i, $counter) {

        $startPage = $i * 10 + 1;
        fetch_phone_num($startPage, $counter);

        $pro->exit();
    }, false);

    $process->start();

}

function fetch_phone_num($page, $counter)
{
    $baseUrl = 'http://www.jihaoba.com/escrow/?&_mhead=1&page=';
    for ($i = $page; $i < $page + 10; $i++) {

        $data = file_get_contents($baseUrl . $i);
        $reg = "/<div class=\"numbershow\">.*?<\/div>/ism";
        preg_match_all($reg, $data, $match);

        foreach ($match[0] as $v) {

            $counter->add();

            $numReg = "/<a href=(.*?).htm\" .*?>.*?<\/a>/ism";
            preg_match_all($numReg, $v, $mat);
            $num = explode('-', $mat[1][0])[1];

            // echo '抓取到的靓号为 ====> ' . $num . PHP_EOL;
        }

    }
}

for ($i = 0; $i < $workerNum; $i++) {
    Process::wait();
}

$res = sprintf('数据总数为 %s，消耗时间为 %s', $counter->get(), (time() - $startTime));
echo $res . PHP_EOL;
