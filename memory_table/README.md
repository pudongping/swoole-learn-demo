# swoole memory table

> 多进程之间共享数据

## 示例

```shell

root@dc705af7d5da:/var/www/swoole-learn-demo/memory_table# php table.php
表格的最大行数 ====> 1024
实际占用内存的尺寸 ====> 194880
表格中的数据总数 ====> 3
array(3) {
  ["name"]=>
  string(4) "Jack"
  ["age"]=>
  int(25)
  ["height"]=>
  float(1.88)
}

现在表格中的数据总数 ====> 2
string(1) "1"
==========>
array(3) {
  ["name"]=>
  string(4) "Alex"
  ["age"]=>
  int(18)
  ["height"]=>
  float(1.68)
}
string(1) "3"
==========>
array(3) {
  ["name"]=>
  string(4) "Mary"
  ["age"]=>
  int(21)
  ["height"]=>
  float(1.78)
}

```
