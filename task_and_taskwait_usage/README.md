# task 和 taskwait

## task 异步投递

### 服务端

```shell

root@dc705af7d5da:/var/www/swoole-learn-demo/task_and_taskwait_usage# php server.php


hello Alex!  # 这里会立刻执行

task ====> task data ====> jack  # 这里需要 10s 后执行

finish result ====> success

```

### 客户端

```shell

telnet 127.0.0.1 5200

```
