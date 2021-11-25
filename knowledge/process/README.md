# 进程 process

## 进程之间通过 pipe 管道通讯

### 启动

```shell

root@dc705af7d5da:/var/www/swoole-learn-demo/process# php process_pipe.php
from pipe ====> child pid ====> 9367
save msg to pipe

```

### 检查进程之间的情况

```shell

root@dc705af7d5da:/var/www/swoole-learn-demo/http_server# ps -ef | grep php | grep -v grep
root      9366    32  1 16:04 pts/1    00:00:00 parent_process:php
root      9367  9366  0 16:04 pts/1    00:00:00 child_process:php
root@dc705af7d5da:/var/www/swoole-learn-demo/http_server# pstree -p 9366
php(9366)───php(9367)

```

## 多进程之间通过 atomic 数据共享

### 启动

```shell

root@dc705af7d5da:/var/www/swoole-learn-demo/process# php multi_process_atomic.php
0 th process ====> child pid ====> 9937
1
1 th process ====> child pid ====> 9938
2
2 th process ====> child pid ====> 9939
3
3 th process ====> child pid ====> 9940
4
4 th process ====> child pid ====> 9941
5
5 th process ====> child pid ====> 9942
6
6 th process ====> child pid ====> 9943
7
7 th process ====> child pid ====> 9944
8
8 th process ====> child pid ====> 9945
9
9 th process ====> child pid ====> 9946
10
总数 ====> 10

```

### 检查进程之间的情况

```shell

root@dc705af7d5da:/var/www/swoole-learn-demo/http_server# ps -ef | grep php | grep -v grep
root      9936    32  1 17:27 pts/1    00:00:00 parent_process:php
root      9937  9936  0 17:27 pts/1    00:00:00 child_process:php
root      9938  9936  0 17:27 pts/1    00:00:00 child_process:php
root      9939  9936  0 17:27 pts/1    00:00:00 child_process:php
root      9940  9936  0 17:27 pts/1    00:00:00 child_process:php
root      9941  9936  0 17:27 pts/1    00:00:00 child_process:php
root      9942  9936  0 17:27 pts/1    00:00:00 child_process:php
root      9943  9936  0 17:27 pts/1    00:00:00 child_process:php
root      9944  9936  0 17:27 pts/1    00:00:00 child_process:php
root      9945  9936  0 17:27 pts/1    00:00:00 child_process:php
root      9946  9936  0 17:27 pts/1    00:00:00 child_process:php
root@dc705af7d5da:/var/www/swoole-learn-demo/http_server# pstree -p 9936
php(9936)─┬─php(9937)
          ├─php(9938)
          ├─php(9939)
          ├─php(9940)
          ├─php(9941)
          ├─php(9942)
          ├─php(9943)
          ├─php(9944)
          ├─php(9945)
          └─php(9946)

```
