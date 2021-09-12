# 服务端向客户端发送数据或者文件

## 启动服务端

```shell

root@dc705af7d5da:/var/www/swoole-learn-demo/send_msg# php server.php

receive start ==> fd ==> [ 1 ] ==> reactor_id ==> [ 6 ] ==> receive data ==> [ 11223344 ]

```

## 客户端连接

```shell

telnet 127.0.0.1 5200

# 并发送一条消息，比如 11223344

11223344
hello world : 11223344

# 以下为直接从文本文件中读取到的内容
hello 11
hello 22
hello 33
hello 44
hello 55

```
