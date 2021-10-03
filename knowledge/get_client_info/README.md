# 获取客户端连接信息

## 用户上线广播通知

### 服务端

```shell

root@dc705af7d5da:/var/www/swoole-learn-demo/get_client_user_info# php server.php

worker_id ====> [ 0 ]
worker_id ====> [ 1 ]
worker_id ====> [ 2 ]
array(15) {
  ["server_port"]=>
  int(5200)
  ["server_fd"]=>
  int(3)
  ["socket_fd"]=>
  int(15)
  ["socket_type"]=>
  int(1)
  ["remote_port"]=>
  int(64146)
  ["remote_ip"]=>
  string(10) "172.28.0.1"
  ["reactor_id"]=>
  int(0)
  ["connect_time"]=>
  int(1632019458)
  ["last_time"]=>
  int(1632019458)
  ["last_recv_time"]=>
  float(1632019458.6676)
  ["last_send_time"]=>
  float(0)
  ["last_dispatch_time"]=>
  float(0)
  ["close_errno"]=>
  int(0)
  ["recv_queued_bytes"]=>
  int(0)
  ["send_queued_bytes"]=>
  int(0)
}

```

### 客户端

> 建议多开几个客户端，方便查看效果

```shell

telnet 127.0.0.1 5200

```


## 用户的 user_id 和 fd 进行绑定

### 服务端

> 绑定结果中会多出一个 `uid` 字段

```shell

root@dc705af7d5da:/var/www/swoole-learn-demo/get_client_info# php server1.php
worker_id ====> [ 0 ]
worker_id ====> [ 1 ]
worker_id ====> [ 2 ]
array(16) {
  ["uid"]=>
  int(536)
  ["server_port"]=>
  int(5200)
  ["server_fd"]=>
  int(3)
  ["socket_fd"]=>
  int(15)
  ["socket_type"]=>
  int(1)
  ["remote_port"]=>
  int(64190)
  ["remote_ip"]=>
  string(10) "172.28.0.1"
  ["reactor_id"]=>
  int(0)
  ["connect_time"]=>
  int(1632024218)
  ["last_time"]=>
  int(1632024218)
  ["last_recv_time"]=>
  float(1632024218.5494)
  ["last_send_time"]=>
  float(0)
  ["last_dispatch_time"]=>
  float(0)
  ["close_errno"]=>
  int(0)
  ["recv_queued_bytes"]=>
  int(0)
  ["send_queued_bytes"]=>
  int(0)
}

```

### 客户端

> 建议多开几个客户端，方便查看效果

```shell

telnet 127.0.0.1 5200

```
