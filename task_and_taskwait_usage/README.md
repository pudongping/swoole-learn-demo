# task 和 taskwait

## task 异步投递任务

### 服务端

```shell

root@dc705af7d5da:/var/www/swoole-learn-demo/task_and_taskwait_usage# php task.php


hello Alex!  # 这里会立刻执行

task ====> task data ====> jack  # 这里需要 10s 后执行

finish result ====> success

```

### 客户端

```shell

telnet 127.0.0.1 5200

```

## taskwait 异步投递任务

### 服务端

- 当 `onTask` 回调函数执行时间小于 `taskwait` 的超时等待时长时

```shell

root@dc705af7d5da:/var/www/swoole-learn-demo/task_and_taskwait_usage# php taskwait.php

task ====> task wait data ====> jack

# 这里打印出来的是 onTask 回调函数的返回结果
string(7) "success"

hello Alex!

```

- 当 `onTask` 回调函数执行时间大于 `taskwait` 的超时等待时长时

```shell

root@dc705af7d5da:/var/www/swoole-learn-demo/task_and_taskwait_usage# php taskwait.php

# 这里打印出来的为 false，因为 onTask 回调函数超时了
bool(false)

hello Alex!
task ====> task wait data ====> jack

# 这里就会报错
[2021-09-20 17:47:26 *598.0]	WARNING	php_swoole_server_onFinish() (ERRNO 2003): task[0] has expired

```


### 客户端

```shell

telnet 127.0.0.1 5200                 

Trying 127.0.0.1...
Connected to localhost.
Escape character is '^]'.
jack

```
