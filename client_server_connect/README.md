# Swoole\Client 同步连接服务端以及长连接使用

## 短连接

### 服务端

```shell

root@dc705af7d5da:/var/www/swoole-learn-demo/client_server_connect# php server.php
connected success!
this is server ====> fd [ 1 ] ==> message [ hello, I am client ]
connected success!
this is server ====> fd [ 2 ] ==> message [ hello, I am client ]
connected success!
this is server ====> fd [ 3 ] ==> message [ hello, I am client ]
connected success!
this is server ====> fd [ 4 ] ==> message [ hello, I am client ]
connected success!
this is server ====> fd [ 5 ] ==> message [ hello, I am client ]

```

### 客户端

```shell

root@dc705af7d5da:/var/www/swoole-learn-demo/client_server_connect# php client.php
我收到消息了_1111
我收到消息了_1111
我收到消息了_1111
我收到消息了_1111
我收到消息了_1111

```

## 长连接

> SWOOLE_KEEP 只允许用于 `同步` 客户端。

### 服务端

```shell

root@dc705af7d5da:/var/www/swoole-learn-demo/client_server_connect# php server.php
connected success!
this is server ====> fd [ 1 ] ==> message [ hello, I am client ]
this is server ====> fd [ 1 ] ==> message [ hello, I am client ]
this is server ====> fd [ 1 ] ==> message [ hello, I am client ]
this is server ====> fd [ 1 ] ==> message [ hello, I am client ]
this is server ====> fd [ 1 ] ==> message [ hello, I am client ]

```

### 客户端

```shell

root@dc705af7d5da:/var/www/swoole-learn-demo/client_server_connect# php client.php
我收到消息了_1111
我收到消息了_1111
我收到消息了_1111
我收到消息了_1111
我收到消息了_1111

```

> 可以观察到，当开启了长连接之后，`fd` 没有变化。
