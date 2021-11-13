# 协程服务端

## 服务端

```shell

root@dc705af7d5da:/var/www/swoole-learn-demo/knowledge/coroutine_server# php server.php
从客户端发来的消息 ====> hello

```

## 客户端

```shell

telnet 127.0.0.1 5200

Trying 127.0.0.1...
Connected to localhost.
Escape character is '^]'.
hello
发送消息啦

```
