# 异步任务投递

## 启动服务端

```shell

root@dc705af7d5da:/var/www/swoole-learn-demo/async_task# php server.php

```

## 客户端连接

```shell

telnet 127.0.0.1 5200

# 并发送一条消息，比如 12345

```

期望结果显示为：

```

receive start ==> fd ==> [ 1 ] reactor_id ==> [ 0 ] ==> data [ 12345]
# 立刻会显示出来
login now
# 10 秒之后会显示出来
task start ==> task_id ==> [ 0 ] ==> src_worker_id ==> [ 4 ] ==> data [ send mail ]
# 显示异步处理的结果
finish start ==> task_id ==> [ 0 ] ==> res ==> [ success ]

```
