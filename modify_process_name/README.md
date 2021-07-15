# 修改 Swoole\Server 进程名称以及打印进程的 pid

## master （主进程）、reactor （线程）、manager（管理进程）、worker （工作进程） 、 task （任务进程）

### master 进程
主进程内有多个 reactor 线程，reactor 线程基于 epoll/kqueue 进行网络事件轮训。收到数据后转发到 worker 进程去处理。

### reactor 线程
reactor 线程个数默认和 cpu 核心数一致

### manager 进程
对所有 worker 进程进行管理，worker 进程生命周期结束或者发生异常时自动回收，并创建新的 worker 进程

### worker 进程
对收到的数据进行处理，包括协议解析和响应请求。如果 swoole 没有设置 worker_num ，底层会启动与 cpu 数量一致的 worker 进程

### task 进程
task 进程和 worker 进程是同级别的，可以将 worker 进程中的一些服务投递给 task 进程进行处理，来达到分担 worker 进程工作量的目的

![进程/线程结构图](https://upload-images.jianshu.io/upload_images/14623749-78ba06649d969718.png?imageMogr2/auto-orient/strip%7CimageView2/2/w/1240)

![swoole 架构](https://upload-images.jianshu.io/upload_images/14623749-aa2ab771fa24e858.png?imageMogr2/auto-orient/strip%7CimageView2/2/w/1240)

![swoole 运行流程图](https://upload-images.jianshu.io/upload_images/14623749-e90a521635fbfee1.png?imageMogr2/auto-orient/strip%7CimageView2/2/w/1240)


## 进程和线程
- 进程  
  进程是一个具有一定独立功能的程序在一个数据集上的一次动态执行的过程，是操作系统进行资源分配和调度的一个独立单位，是应用程序运行的载体。
- 线程  
  线程是程序执行中一个单一的顺序控制流程，是程序执行流的最小单元，是处理器调度和分派的基本单位。一个进程可以有一个或多个线程。

### 进程和线程的区别
- 线程是程序执行的最小单位，而进程是操作系统分配资源的最小单位。
- 一个进程由一个或多个线程组成，线程是一个进程中代码的不同执行路线。
- 进程之间相互独立，但同一进程下的各个线程之间共享程序的内存空间（包括代码段，数据集，堆等）及一些进程级的资源（如打开文件和信号等），某进程内的线程在其他进程不可见。
- 调度和切换：线程上下文切换比进程上下文切换要快得多。
- 线程天生的共享内存空间，线程间的通信更简单，避免了进程 IPC（进程间的通信） 引入新的复杂度。
- 进程开销大，线程开销小。

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

## 正常退出 task 进程时

```shell

kill -9 674

# server.php 输出如下内容

[2021-07-14 16:04:15 $669.0]	WARNING	check_worker_exit_status: worker#6[pid=674] abnormal exit, status=0, signal=9
worker error =====> worker_id ==> 6 pid ==> 674 code ==> 0 signal ==> 9
task_pid ======> 732 =====> task_id ======> 6

# 我们可以看到 swoole 会重新启动一个新的 task 进程 （新启动的一个 task 进程的 pid 为 732）

root@2c73d27f94b1:/var/www# ps -aux | grep php | grep -v grep
root       668  0.0  1.5 683488 31024 pts/1    Sl+  15:53   0:00 php:swoole:master
root       669  0.0  0.5 390644 11396 pts/1    S+   15:53   0:00 php:swoole:manager
root       675  0.0  0.4 391448 10120 pts/1    S+   15:53   0:00 php:swoole:task
root       676  0.0  0.4 391448 10120 pts/1    S+   15:53   0:00 php:swoole:task
root       677  0.0  0.6 391448 13056 pts/1    S+   15:53   0:00 php:swoole:work
root       678  0.0  0.6 391448 13056 pts/1    S+   15:53   0:00 php:swoole:work
root       679  0.0  0.6 391448 13056 pts/1    S+   15:53   0:00 php:swoole:work
root       680  0.0  0.6 391448 13056 pts/1    S+   15:53   0:00 php:swoole:work
root       681  0.0  0.6 391408 13508 pts/1    S+   15:53   0:00 php:swoole:work
root       682  0.0  0.6 391448 13056 pts/1    S+   15:53   0:00 php:swoole:work
root       732  0.0  0.4 391448  9640 pts/1    S+   16:04   0:00 php:swoole:task

root@2c73d27f94b1:/var/www# pstree -p 668
php(668)─┬─php(669)─┬─php(675)
         │          ├─php(676)
         │          ├─php(677)
         │          ├─php(678)
         │          ├─php(679)
         │          ├─php(680)
         │          ├─php(681)
         │          ├─php(682)
         │          └─php(732)
         ├─{php}(670)
         ├─{php}(671)
         ├─{php}(672)
         └─{php}(673)

```

## 异常退出一个 work 进程时

```shell

kill -15 677

# server.php 输出如下内容

worker stop =====> worker_id ==> 0
worker_pid =====> 786 =====> worker_id =====> 0

# 我们可以看到 swoole 会重新启动一个新的 work 进程 （新启动的一个 work 进程的 pid 为 786）

root@2c73d27f94b1:/var/www# ps -aux | grep php | grep -v grep
root       668  0.0  1.5 683488 31024 pts/1    Sl+  15:53   0:00 php:swoole:master
root       669  0.0  0.6 390644 13260 pts/1    S+   15:53   0:00 php:swoole:manager
root       675  0.0  0.4 391448 10120 pts/1    S+   15:53   0:00 php:swoole:task
root       676  0.0  0.4 391448 10120 pts/1    S+   15:53   0:00 php:swoole:task
root       678  0.0  0.6 391448 13056 pts/1    S+   15:53   0:00 php:swoole:work
root       679  0.0  0.6 391448 13056 pts/1    S+   15:53   0:00 php:swoole:work
root       680  0.0  0.6 391448 13056 pts/1    S+   15:53   0:00 php:swoole:work
root       681  0.0  0.6 391408 13508 pts/1    S+   15:53   0:00 php:swoole:work
root       682  0.0  0.6 391448 13056 pts/1    S+   15:53   0:00 php:swoole:work
root       732  0.0  0.4 391448  9640 pts/1    S+   16:04   0:00 php:swoole:task
root       786  0.0  0.6 391448 12456 pts/1    S+   16:09   0:00 php:swoole:work

root@2c73d27f94b1:/var/www# pstree -p 668
php(668)─┬─php(669)─┬─php(675)
         │          ├─php(676)
         │          ├─php(678)
         │          ├─php(679)
         │          ├─php(680)
         │          ├─php(681)
         │          ├─php(682)
         │          ├─php(732)
         │          └─php(786)
         ├─{php}(670)
         ├─{php}(671)
         ├─{php}(672)
         └─{php}(673)

```

## 正常退出主进程时

```shell

kill -9 668

# server.php 输出如下内容

worker stop =====> worker_id ==> 3
worker stop =====> worker_id ==> 0
worker stop =====> worker_id ==> 4
worker stop =====> worker_id ==> 1
worker stop =====> worker_id ==> 2
worker stop =====> worker_id ==> 5

```
