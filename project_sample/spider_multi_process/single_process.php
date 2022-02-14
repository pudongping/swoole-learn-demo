<?php
/**
 * 单进程爬虫程序
 *
 * Created by PhpStorm
 * User: Alex
 * Date: 2021-10-03 02:12
 * E-mail: <276558492@qq.com>
 */
declare(strict_types=1);

$startTime = time();

static $total = 0;

$baseUrl = 'http://www.jihaoba.com/escrow/?&_mhead=1&page=';
for ($i = 1; $i < 51; $i++) {

    $data = file_get_contents($baseUrl . $i);
    $reg = "/<div class=\"numbershow\">.*?<\/div>/ism";

    preg_match_all($reg, $data, $match);

    /**
    [0]=>
    string(488) "<div class="numbershow">
    <ul>
    <li class="number hmzt"><a href="/escrow/158-15827717333.htm" target="_blank">15827717<span class="red">333</span></a></li>
    <li class="price"><span class="red">￥4000</span>/￥1000</li>
    <li class="brand"><i class="brand_icon yidong"></i>荆州移动</li>
    <li class="law" style="color:#8d8d8d;">号码由荆州张女士委托转让</li>
    <li class="operation"><a class="reserve" href="/escrow/158-15827717333.htm" target="_blank">查看</a></li>
    </ul>
    </div>"
     **/
    // var_dump($match[0]);

    foreach ($match[0] as $v) {
        $total++;

        $numReg = "/<a href=(.*?).htm\" .*?>.*?<\/a>/ism";
        preg_match_all($numReg, $v, $mat);
        // var_dump($mat[1][0]);
        $num = explode('-', $mat[1][0])[1];

        // echo '抓取到的靓号为 ====> ' . $num . PHP_EOL;

    }

}

$res = sprintf('数据总数为 %s，消耗时间为 %s', $total, (time() - $startTime));
echo $res . PHP_EOL;
