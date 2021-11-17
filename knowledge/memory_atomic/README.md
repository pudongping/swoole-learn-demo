# 进程间无锁计数器 Atomic

线程安全主要体现在以下三个方面：

- 原子性：提供了互斥访问，同一时刻只能有一个线程对它进行操作；
- 可见性：一个线程对主内存的修改可以及时的被其他线程观察到；
- 有序性：一个线程观察其他线程中的指令执行顺序，由于指令重排序的存在，该观察结果一般杂乱无序。

## atomic

```shell

root@dc705af7d5da:/var/www/swoole-learn-demo/memory_atomic# php atomic.php
24
18
30

```

## wait and wakeup

```shell

root@dc705af7d5da:/var/www/swoole-learn-demo/memory_atomic# php wait_and_wakeup.php
master start
child start
child end
master end

```
