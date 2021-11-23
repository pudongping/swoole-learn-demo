# 服务端多端口监听

## 服务端

```shell

root@dc705af7d5da:/var/www/swoole-learn-demo/multi_port# php server.php
9506 port ====> hello-9506

9505 port ====> hello-9505

```

查看端口监听情况，可见 9505 端口和 9506 端口已经被监听

```shell

root@dc705af7d5da:/var/www/swoole-learn-demo/multi_port# netstat -ntlp | grep 950* | grep -v grep
tcp        0      0 0.0.0.0:9505            0.0.0.0:*               LISTEN      1461/php
tcp        0      0 0.0.0.0:9506            0.0.0.0:*               LISTEN      1461/php

```

## 客户端

客户端连接，并发送简单的消息

```shell

telnet 127.0.0.1 9506

Trying 127.0.0.1...
Connected to localhost.
Escape character is '^]'.
hello-9506

```

另起一个客户端并发送简单的消息

```shell


telnet 127.0.0.1 9505

Trying 127.0.0.1...
Connected to localhost.
Escape character is '^]'.
hello-9505

```
