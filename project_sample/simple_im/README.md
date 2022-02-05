# 简单的 im 客服聊天系统（带心跳检测）

## 服务端启动

```shell

root@dc705af7d5da:/var/www/swoole-learn-demo/project_sample/simple_im# php server.php
server: handshake success with fd1
receive from 1:{"event":"heart_beat"},opcode:1,fin:1
server: handshake success with fd2
receive from 2:{"event":"heart_beat"},opcode:1,fin:1
receive from 1:{"event":"heart_beat"},opcode:1,fin:1
receive from 2:{"event":"service_chat","receiver":{"id":1,"type":"admin"},"body":{"type":"text","content":"hello"}},opcode:1,fin:1
receive from 2:{"event":"heart_beat"},opcode:1,fin:1
receive from 1:{"event":"heart_beat"},opcode:1,fin:1
receive from 1:{"event":"service_chat","receiver":{"id":1,"type":"user"},"body":{"type":"text","content":"nihaoa"}},opcode:1,fin:1

```

## 客户端启动

只需要在浏览器中访问 `admin1.html` 和 `user1.html` 即可。

html 代码中提供了分别提供了两种心跳检测的方式，可供参考。**推荐使用 `admin1.html` 文件中的心跳检测方式**。
