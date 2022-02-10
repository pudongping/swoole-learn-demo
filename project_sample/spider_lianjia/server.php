<?php
/**
 * 抓取链家网上海市房屋租赁信息
 *
 * Created by PhpStorm
 * User: Alex
 * Date: 2021-10-04 03:58
 * E-mail: <276558492@qq.com>
 */
declare(strict_types=1);

use Swoole\Process;

// 记录开始时间
$startTime = time();

// 需要抓取的上海地区区
$citys = [
    'jingan',  // 静安区
    'xuhui',  // 徐汇区
    'huangpu',  // 黄浦区
    'changning',  // 长宁区
    'putuo',  // 普陀区
    'pudong',  // 浦东区
    'baoshan',  // 宝山区
    'hongkou',  // 虹口区
    'yangpu',  // 杨浦区
    'minhang',  // 闵行区
    'jinshan',  // 金山区
    'jiading',  // 嘉定区
    'chongming',  // 崇明区
    'fengxian',  // 奉贤区
    'songjiang',  // 松江区
    'qingpu',  // 青浦区
];

// $citys = ['jingan', 'xuhui'];

$workers = [];
$maxPage = 10;  // 最大页码数

$mysqlCfg = [
    'host' => '172.28.0.5',
    'port' => 3306,
    'user' => 'root',
    'password' => 'root',
    'database' => 'ubiquitous',
];

// 创建多进程
foreach ($citys as $city) {

    $process = new Process(function ($childProcess) use ($city, $maxPage) {
        // 修改子进程的名称
        $childProcess->name($city . ':php');

        for ($i = 1; $i <= $maxPage; $i++) {
            $url = 'https://sh.lianjia.com/zufang/' . $city . '/pg' . $i;
            $data = fetch_data($url);  // 获取需要抓取的信息
            if (! $data) {
                continue;
            }
            $childProcess->push(json_encode($data, 256));  // 将数据推到消息队列中
        }

        // 执行完毕之后需要退出当前的子进程
        $childProcess->exit();
    });

    $process->useQueue();  // 使用消息队列
    $childPid = $process->start();

    // 修改父进程的名称
    $process->name('parent_process:php');

    $workers[$childPid] = $process;
}

// 消费消息队列中的数据
foreach ($workers as $worker) {
    for ($i = 1; $i <= $maxPage; $i++) {
        $data = $worker->pop();  // 从进程中取出投递到消息队列中的数据
        // var_dump($data . PHP_EOL);
        // 将数据存入数据库中
        insert_data($data, $mysqlCfg);
    }
}

// 回收子进程的资源，防止僵死进程的出现
foreach ($citys as $kk) {
    Process::wait();
}

// 将数据写入 mysql 中
function insert_data($data, $config)
{
    $data = json_decode($data, true);

    // 协程 mysql 存储数据
    $scheduler = new Swoole\Coroutine\Scheduler;
    $scheduler->add(function () use ($data, $config) {
        $mysql = new Swoole\Coroutine\Mysql();
        $ret1 = $mysql->connect($config);

        foreach ($data as $v) {
            $stmt = $mysql->prepare('INSERT INTO `ubiquitous`.`house` (`title`, `address`, `square`, `direction`, `house_type`, `price`, `created_at`) VALUES (?, ?, ?, ?, ?, ?, ?)');
            if ($stmt == false) {
                var_dump($mysql->errno, $mysql->error);
            } else {
                $ret2 = $stmt->execute([
                    $v['title'] ?? '',
                    $v['address'] ?? '',
                    $v['square'] ?? '',
                    $v['direction'] ?? '',
                    $v['house_type'] ?? '',
                    $v['price'] ?? '',
                    date('Y-m-d H:i:s')]);
            }
        }

    });
    $scheduler->start();

}

/*
<div class="content__list--item--main">
      <p class="content__list--item--title">
        <a class="twoline" target="_blank" href="/zufang/SH2867494136565735424.html">
    整租·金隅金成府 3室1厅 南/北        </a>
                      </p>
      <p class="content__list--item--des">
                <a target="_blank" href="/zufang/jiading/">嘉定</a>-<a href="/zufang/xuxing/" target="_blank">徐行</a>-<a title="金隅金成府" href="/zufang/c5020044734196704/" target="_blank">金隅金成府</a>
        <i>/</i>
92.00㎡
<i>/</i>南 北        <i>/</i>
3室1厅1卫        <span class="hide">
          <i>/</i>
高楼层                        （12层）
</span>
      </p>
      <p class="content__list--item--bottom oneline">
            <i class="content__item__tag--decoration">精装</i>
            </p>
      <p class="content__list--item--brand oneline">
                  <span class="brand">
链家          </span>
                <span class="content__list--item--time oneline">2天前维护</span>
      </p>
            <span class="content__list--item-price"><em>4300</em> 元/月</span>
    </div>
*/

// 正则匹配 html 以获取指定数据
function fetch_data($url)
{
    $html = file_get_contents($url);
    if (! $html) {
        return [];
    }
    $pregDiv = '/<div class=\"content__list--item--main\">.*?<\/div>/ism';
    preg_match_all($pregDiv, $html, $matchDiv);

    $data = [];
    foreach ($matchDiv[0] as $k => $v) {
        // 匹配房产信息的标题、地址
        $pregA = '/<a .*?>.*?<\/a>/ism';
        preg_match_all($pregA, $v, $matchA);
        if (count($matchA[0]) < 4) {
            continue;
        }
        [$a, $b, $c, $d] = $matchA[0];
        $data[$k]['title'] = trim(strip_tags($a));  // 房产标题
        $data[$k]['address'] = trim(strip_tags($b)) . '/' . trim(strip_tags($c)) . '/' . trim(strip_tags($d));  // 地址

        // 匹配房产信息的面积、朝向、户型
        $pregB = '/<\/i>.*?<i>/ism';
        preg_match_all($pregB, $v, $matchB);
        if (count($matchB[0]) < 3) {
            continue;
        }
        [$e, $f, $g] = $matchB[0];
        $data[$k]['square'] = trim(strip_tags($e));  // 面积
        $data[$k]['direction'] = trim(strip_tags($f));  // 朝向
        $data[$k]['house_type'] = trim(strip_tags($g));  // 户型

        // 匹配价格
        $pregC = '/<em>.*?<\/em>/ism';
        preg_match_all($pregC, $v, $matchC);
        $data[$k]['price'] = trim(strip_tags($matchC[0][0]));  // 价格

    }

    return $data;
}


$s = sprintf('总共耗时为： %s', (time() - $startTime));
echo $s . PHP_EOL;
