# 修改进程名称以及打印进程的 pid

## 启动服务端

```shell

root@2c73d27f94b1:/var/www/swoole-learn-demo/modify_process_name# php server.php
master_pid =====> 668
manager_pid =====> 669
task_pid ======> 674 =====> task_id ======> 6
task_pid ======> 675 =====> task_id ======> 7
task_pid ======> 676 =====> task_id ======> 8
worker_pid =====> 677 =====> worker_id =====> 0
worker_pid =====> 678 =====> worker_id =====> 1
worker_pid =====> 679 =====> worker_id =====> 2
worker_pid =====> 680 =====> worker_id =====> 3
worker_pid =====> 681 =====> worker_id =====> 4
worker_pid =====> 682 =====> worker_id =====> 5

```

## 查看进程修改后的名称

```shell

root@2c73d27f94b1:/var/www# ps -aux | grep php | grep -v grep
root       668  0.0  1.5 683488 31024 pts/1    Sl+  15:53   0:00 php:swoole:master
root       669  0.0  0.5 390644 11396 pts/1    S+   15:53   0:00 php:swoole:manager
root       674  0.0  0.4 391448 10120 pts/1    S+   15:53   0:00 php:swoole:task
root       675  0.0  0.4 391448 10120 pts/1    S+   15:53   0:00 php:swoole:task
root       676  0.0  0.4 391448 10120 pts/1    S+   15:53   0:00 php:swoole:task
root       677  0.0  0.6 391448 13056 pts/1    S+   15:53   0:00 php:swoole:work
root       678  0.0  0.6 391448 13056 pts/1    S+   15:53   0:00 php:swoole:work
root       679  0.0  0.6 391448 13056 pts/1    S+   15:53   0:00 php:swoole:work
root       680  0.0  0.6 391448 13056 pts/1    S+   15:53   0:00 php:swoole:work
root       681  0.0  0.6 391448 13056 pts/1    S+   15:53   0:00 php:swoole:work
root       682  0.0  0.6 391448 13056 pts/1    S+   15:53   0:00 php:swoole:work

```

## 查看进程树形结构

```shell

root@2c73d27f94b1:/var/www# pstree -p 668
php(668)─┬─php(669)─┬─php(674)
         │          ├─php(675)
         │          ├─php(676)
         │          ├─php(677)
         │          ├─php(678)
         │          ├─php(679)
         │          ├─php(680)
         │          ├─php(681)
         │          └─php(682)
         ├─{php}(670)
         ├─{php}(671)
         ├─{php}(672)
         └─{php}(673)

```

## 客户端连接

```shell

telnet 127.0.0.1 5200

# server.php 输出如下内容

connect =====> fd ==> 1 reactor_id ==> 0
array(14) {
  ["start_time"]=>
  int(1626277997)
  ["connection_num"]=>
  int(1)
  ["accept_count"]=>
  int(1)
  ["close_count"]=>
  int(0)
  ["worker_num"]=>
  int(6)
  ["idle_worker_num"]=>
  int(5)
  ["task_worker_num"]=>
  int(3)
  ["tasking_num"]=>
  int(0)
  ["request_count"]=>
  int(0)
  ["dispatch_count"]=>
  int(0)
  ["worker_request_count"]=>
  int(0)
  ["worker_dispatch_count"]=>
  int(0)
  ["task_idle_worker_num"]=>
  int(3)
  ["coroutine_num"]=>
  int(1)
}

```
