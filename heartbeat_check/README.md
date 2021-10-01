# 心跳检测

## 服务端

```shell

root@dc705af7d5da:/var/www/swoole-learn-demo/heartbeat_check# php server.php

```

## 客户端

```shell

Trying 127.0.0.1...
Connected to localhost.
Escape character is '^]'.
hello # 随便发送一条数据
Connection closed by foreign host.  # 如果 15s 内没有发送数据，则服务端会主动关闭连接

```
