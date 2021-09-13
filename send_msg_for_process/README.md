# 进程之间数据发送

## 启动服务端

```shell

root@dc705af7d5da:/var/www/swoole-learn-demo/send_msg_for_process# php server.php

worker_id ==> [ 0 ]
worker_id ==> [ 1 ]
worker_id ==> [ 2 ]
receive start ==> fd ==> [ 1 ] ==> reactor_id ==> [ 0 ] ==> receive data ==> [ 123456 ]
current worker_id is ==> 0
pipeMessage start ==> 自身的 worker_id ==> [ 1 ] 来源于哪个 worker_id ==> [ 0 ] 收到的消息内容为 ==> [ hello Alex  ]

```

## 客户端连接

```shell

telnet 127.0.0.1 5200

# 并发送一条消息，比如 123456

``` 
