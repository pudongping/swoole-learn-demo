# process 进程消息队列

## 启动

> 需要注意的点是：`useQueue` 方法一定要在 `start` 方法之前调用。

```shell

root@dc705af7d5da:/var/www/swoole-learn-demo/process_queue# php queue.php
10224
this is children pid ====> 10199
10225
this is children pid ====> 10200
10226
this is children pid ====> 10201
10227
this is children pid ====> 10202
10228
this is children pid ====> 10224
10229
this is children pid ====> 10225
10230
this is children pid ====> 10226
10231
this is children pid ====> 10227
10232
this is children pid ====> 10228
10233
this is children pid ====> 10229

```
