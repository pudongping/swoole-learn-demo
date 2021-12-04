# 基于 Process\Pool 通过进程池实现数据库和 Redis 的持久连接

## 服务端启动

```shell

root@dc705af7d5da:/var/www/swoole-learn-demo/knowledge/process_pool# php pool.php
Worker#0 is started
Worker#1 is started
Worker#2 is started
Worker#3 is started
Worker#4 is started
array(2) {
  [0]=>
  string(4) "key1"
  [1]=>
  string(4) "hhhh"
}
Processed by Worker#1
array(2) {
  [0]=>
  string(4) "key1"
  [1]=>
  string(5) "hello"
}
Processed by Worker#2

```

## 客户端

```shell

# 启动 redis 客户端，并往 key1 列表中推送数据
redis-cli

lpush key1 hhhh
lpush key1 hello

```

## 查看进程之间关系

```shell

root@dc705af7d5da:/var/www# ps -aux | grep php | grep -v grep
root     25497  0.0  1.6 104512 33316 pts/1    S+   14:15   0:00 php pool.php
root     25498  0.0  0.6 106564 12332 pts/1    S+   14:15   0:00 php pool.php
root     25499  0.0  0.6 106564 12332 pts/1    S+   14:15   0:00 php pool.php
root     25500  0.0  0.6 106564 12332 pts/1    S+   14:15   0:00 php pool.php
root     25501  0.0  0.6 106564 12332 pts/1    S+   14:15   0:00 php pool.php
root     25502  0.0  0.6 106564 12332 pts/1    S+   14:15   0:00 php pool.php

```
