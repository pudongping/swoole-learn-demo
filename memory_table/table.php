<?php
/**
 * 可以用于多进程之间共享数据
 *
 * Created by PhpStorm
 * User: Alex
 * Date: 2021-10-02 00:18
 * E-mail: <276558492@qq.com>
 */
declare(strict_types=1);

use Swoole\Table;

$userTable = new swoole_table(1024);

$userTable->column('name', Table::TYPE_STRING, 40);
$userTable->column('age', Table::TYPE_INT, 1);
$userTable->column('height', Table::TYPE_FLOAT);

$userTable->create();

// save
$userTable->set('1', [
    'name' => 'Alex',
    'age' => 18,
    'height' => 1.68
]);

$userTable->set('2', [
    'name' => 'Jack',
    'age' => 25,
    'height' => 1.88
]);

$userTable->set('3', [
    'name' => 'Mary',
    'age' => 20,
    'height' => 1.75
]);

echo '表格的最大行数 ====> ' . $userTable->size . PHP_EOL;
echo '实际占用内存的尺寸 ====> ' . $userTable->memorySize . PHP_EOL;
echo '表格中的数据总数 ====> ' . $userTable->count() . PHP_EOL;

var_dump($userTable->get('2'));

echo PHP_EOL;

// 删除一条数据
$userTable->del('2');

echo '现在表格中的数据总数 ====> ' . $userTable->count() . PHP_EOL;

// 修改值
$userTable->set('3', [
    'name' => 'Mary',
    'age' => 21,
    'height' => 1.78
]);

foreach ($userTable as $k => $v) {
    var_dump($k);
    echo '==========> ' . PHP_EOL;
    var_dump($v);
}

