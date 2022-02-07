# 基于 Swoole 实现最简单的 WebSocket 服务器及客户端 

> [JavaScript 调用浏览器内置的 WebSocket API](https://developer.mozilla.org/zh-CN/docs/Web/API/WebSockets_API)

WebSocket 复用了 HTTP 协议来实现握手，然后通过请求报文中的 `Upgrade` 字段将 HTTP 协议升级到 WebSocket 协议来建立 WebSocket 通信连接，
一旦 WebSocket 连接建立之后，就可以在这个长连接上通过 WebSocket 数据帧进行双向通信，客户端和服务端可以在任何时候向对方发送报文，
而不是 HTTP 协议那种服务端只有在客户端发起请求后才能响应，从而解决了在 Web 页面实时显示最新资源的问题。

与 HTTP 类似，WebSocket 协议对应的 scheme 是 `ws`，如果是加密的 WebSocket 对应的 scheme 是 `wss`。

## 服务端启动

```shell

root@dc705af7d5da:/var/www/swoole-learn-demo/project_sample/simple_websocket_webchat# php ws_server.php
server: handshake success with fd1
receive from 1:alex: hello,opcode:1,fin:1


```

## 客户端启动

直接访问在浏览器中访问 `ws_client.html` 即可。
