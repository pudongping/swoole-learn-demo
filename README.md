# swoole-learn-demo

本项目为本人学习 swoole 时写的一部分 demo，以及实现的一些简单的小项目，仅供学习参考。

## 开发环境

> php version: 7.3.27  
> swoole version: 4.6.3

## 目录

### 细节知识点

- [设置 Swoole\Server 的属性并获取属性](./knowledge/fetch_property)
- [修改 Swoole\Server 进程名称以及打印进程的 pid](./knowledge/modify_process_name)
- [异步投递任务](./knowledge/async_task)
- [服务端向客户端发送数据或者文件](./knowledge/send_msg)
- [进程之间数据发送](./knowledge/send_msg_for_process)
- [获取客户端连接信息](./knowledge/get_client_info)
- [task 和 taskwait 的使用](./knowledge/task_and_taskwait_usage)
- [taskWaitMulti 和 taskCo 的使用](./knowledge/taskWaitMulti_and_taskCo_usage)
- [服务端多端口监听](./knowledge/multi_port)
- [毫秒级定时器](./knowledge/tick)
- [服务端心跳检测](./knowledge/heartbeat_check)
- [Swoole\Client 同步连接服务端以及长连接使用](./knowledge/client_server_connect)
- [多进程之间共享数据 memory table](./knowledge/memory_table)
- [进程间无锁计数器 memory atomic](./knowledge/memory_atomic)
- [http 服务器以及配置 https ssl 证书](./knowledge/http_server)
- [WebSocket 服务器以及配置 ssl 证书](./knowledge/websocket_server)
- [多进程以及进程之间通信](./knowledge/process)
- [process 进程消息队列实现进程之间通信](./knowledge/process_queue)
- [基于 Process\Pool 通过进程池实现 Mysql 数据库和 Redis 的持久连接](./knowledge/process_pool)  
- [Coroutine 协程创建的几种方式](./knowledge/coroutine)
- [多协程开启以及传参](./knowledge/coroutine_scheduler)
- [协程通信 channel](./knowledge/coroutine_channel)
- [协程服务端](./knowledge/coroutine_server)
- [协程 http 服务器](./knowledge/coroutine_http_server)
- [协程 redis 客户端](./knowledge/coroutine_redis)
- [协程 mysql 客户端](./knowledge/coroutine_mysql)

### 项目示例

- [多进程爬虫 - 爬取手机号码靓号](./project_sample/spider_multi_process)
- [模拟电影票在线选座](./project_sample/movie_tickets)
- [直播、视频弹幕](./project_sample/barrage)
- [多进程消息队列，使用协程爬取链家网信息](./project_sample/spider_lianjia)
- [基于 Swoole 实现最简单的 WebSocket 服务器及客户端](./project_sample/simple_websocket_webchat)
- [简单的 im 客服聊天系统（带心跳检测）](./project_sample/simple_im)
