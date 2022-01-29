# WebSocket

WebSocket 是一种在单个 TCP 连接上进行全双工通讯的协议。使得客户端和服务器之间的数据交换变得更加简单，
允许服务端主动向客户端推送数据。

应用场景：web 聊天室

## 服务端

```shell

root@dc705af7d5da:/var/www/swoole-learn-demo/websocket_server# php ws_server.php
服务端收到了客户端发来的消息 ====> hello websocket server
关闭连接前，连接是否还存在 ====>
bool(true)
关闭连接后，连接是否还存在 ====>
bool(false)

```

## 客户端

直接通过浏览器去访问 `ws_client.html` 文件，打开控制台，可以看到输出内容为以下

```

connected success
ws_client.html:21 服务端发送过来的消息为 ====> hello, connected server success
ws_client.html:21 服务端发送过来的消息为 ====> hello client web
ws_client.html:25 客户端已经被关闭

```
