# taskWaitMulti 和 taskCo

## taskWaitMulti

并发执行多个 task 异步任务

### 服务端

```shell

root@dc705af7d5da:/var/www/swoole-learn-demo/taskWaitMulti_and_taskCo_usage# php taskWaitMulti.php
task ====> 2
task ====> 1
task ====> 3
array(3) {
  [0]=>
  string(8) "success1"
  [1]=>
  string(8) "success2"
  [2]=>
  string(8) "success3"
}
hello Alex!


```

### 客户端

```shell

telnet 127.0.0.1:5200

Trying 127.0.0.1...
Connected to localhost.
Escape character is '^]'.
hello


```

## taskCo

并发执行 task 并进行协程调度

### 服务端

```shell

root@dc705af7d5da:/var/www/swoole-learn-demo/taskWaitMulti_and_taskCo_usage# php taskCo.php
task ====> 1
task ====> 2
array(3) {
  [1]=>
  string(8) "success2"
  [0]=>
  string(8) "success1"
  [2]=>
  bool(false)
}
hello Alex!
task ====> 3
[2021-10-01 12:12:57 *582.0]	WARNING	php_swoole_server_onFinish() (ERRNO 2003): task[2] has expired


```

### 客户端

```shell

telnet 127.0.0.1:5200

Trying 127.0.0.1...
Connected to localhost.
Escape character is '^]'.
hello

```

> 二者区别在于 taskWaitMulti 主进程等待

