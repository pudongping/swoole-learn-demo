# 毫秒级别计时器

> tick 和 timer 其实是差不多的

## 服务端

```shell

root@dc705af7d5da:/var/www/swoole-learn-demo/tick# php timer.php
Alex
3000 毫秒后执行一次，便直接结束了
Alex
Alex
Alex
Alex
10000 毫秒后要被清除定时器了
不会再执行了

```

## 客户端

```shell

telnet 127.0.0.1 5200

Trying 127.0.0.1...
Connected to localhost.
Escape character is '^]'.
hello # 随便发送一条消息触发一下服务端执行

```
