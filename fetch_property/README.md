# 设置 Swoole\Server 的属性并获取属性

## 启动服务端

```shell

root@2c73d27f94b1:/var/www/swoole-learn-demo/fetch_property# php server.php
task_pid ====> 1927
task_pid ====> 1928
task_pid ====> 1929
worker_pid ====> 1930
worker_pid ====> 1931
worker_pid ====> 1932
worker_pid ====> 1933
worker_pid ====> 1934
worker_pid ====> 1935

```


## 客户端连接

```shell

telnet 127.0.0.1 5200

# 并发送一条消息，比如 hello Alex!

# server.php 输出如下内容

设置项为 ====> array (
  'worker_num' => 6,
  'reactor_num' => 4,
  'task_worker_num' => 3,
  'output_buffer_size' => 2097152,
  'max_connection' => 100000,
)
master_pid ====> 1921
manager_pid ====> 1922
worker_pid ====> 1934
接收到的数据为 ====> 'hello Alex!'
当前所有的文件描述符连接 ====> 1

```

## 查看进程

```shell

root@2c73d27f94b1:/var/www# pstree -p 1921
php(1921)─┬─php(1922)─┬─php(1927)
          │           ├─php(1928)
          │           ├─php(1929)
          │           ├─php(1930)
          │           ├─php(1931)
          │           ├─php(1932)
          │           ├─php(1933)
          │           ├─php(1934)
          │           └─php(1935)
          ├─{php}(1923)
          ├─{php}(1924)
          ├─{php}(1925)
          └─{php}(1926)
  
          
root@2c73d27f94b1:/var/www# ps -aux | grep php | grep -v grep
root      1921  0.0  1.5 683488 30760 pts/1    Sl+  16:40   0:00 php server.php
root      1922  0.0  0.4 390644  9940 pts/1    S+   16:40   0:00 php server.php
root      1927  0.0  0.4 391448 10032 pts/1    S+   16:40   0:00 php server.php
root      1928  0.0  0.4 391448 10032 pts/1    S+   16:40   0:00 php server.php
root      1929  0.0  0.4 391448 10032 pts/1    S+   16:40   0:00 php server.php
root      1930  0.0  0.6 391448 12848 pts/1    S+   16:40   0:00 php server.php
root      1931  0.0  0.6 391448 12848 pts/1    S+   16:40   0:00 php server.php
root      1932  0.0  0.6 391448 12848 pts/1    S+   16:40   0:00 php server.php
root      1933  0.0  0.6 391448 12848 pts/1    S+   16:40   0:00 php server.php
root      1934  0.0  0.6 391408 13236 pts/1    S+   16:40   0:00 php server.php
root      1935  0.0  0.6 391448 12848 pts/1    S+   16:40   0:00 php server.php


root@2c73d27f94b1:/var/www# netstat -ntlp | grep 5200 | grep -v grep
tcp        0      0 0.0.0.0:5200            0.0.0.0:*               LISTEN      1921/php

```
