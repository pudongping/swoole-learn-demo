# 协程 http 服务器

## 服务端启动

```shell

root@dc705af7d5da:/var/www/swoole-learn-demo/knowledge/coroutine_http_server# php http_server.php

```

## 客户端访问

```shell

curl 127.0.0.1:5200

# hello coroutine http

curl 127.0.0.1:5200/alex

# hello alex

```
