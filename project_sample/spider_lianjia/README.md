# 多进程消息队列协程爬取链家网信息

## 服务端

```shell

root@dc705af7d5da:/var/www/swoole-learn-demo/project_sample/spider_lianjia# php server.php
总共耗时为： 11

```

## 查看进程之间关系

```shell

root@dc705af7d5da:/var/www# ps -aux | grep php | grep -v grep
root     19894 12.0  1.6 106832 34396 pts/1    R+   04:49   0:00 parent_process:php
root     19895  0.5  0.9 106808 19876 pts/1    S+   04:49   0:00 jingan:php
root     19896  0.5  0.9 106808 19856 pts/1    S+   04:49   0:00 xuhui:php
root     19897  0.0  0.9 106808 19892 pts/1    S+   04:49   0:00 huangpu:php
root     19898  0.5  0.9 106808 19880 pts/1    S+   04:49   0:00 changning:php
root     19899  0.5  0.9 106808 19888 pts/1    S+   04:49   0:00 putuo:php
root     19900  0.5  0.9 106808 19896 pts/1    S+   04:49   0:00 pudong:php
root     19901  0.0  0.9 106808 19884 pts/1    S+   04:49   0:00 baoshan:php
root     19902  0.5  0.9 106812 19892 pts/1    S+   04:49   0:00 hongkou:php
root     19903  0.0  0.9 106812 19892 pts/1    S+   04:49   0:00 yangpu:php
root     19904  0.5  0.9 106812 19900 pts/1    S+   04:49   0:00 minhang:php
root     19905  1.0  0.9 106812 19908 pts/1    S+   04:49   0:00 jinshan:php
root     19906  1.0  0.9 106812 19912 pts/1    S+   04:49   0:00 jiading:php
root     19907  0.5  0.9 106812 19904 pts/1    S+   04:49   0:00 chongming:php
root     19908  0.5  0.9 106816 19904 pts/1    S+   04:49   0:00 fengxian:php
root     19909  1.0  0.9 106816 19848 pts/1    S+   04:49   0:00 songjiang:php
root     19910  0.0  0.9 106816 19908 pts/1    S+   04:49   0:00 qingpu:php
root@dc705af7d5da:/var/www# pstree -p 19894
php(19894)─┬─php(19895)
           ├─php(19896)
           ├─php(19897)
           ├─php(19898)
           ├─php(19899)
           ├─php(19900)
           ├─php(19901)
           ├─php(19902)
           ├─php(19903)
           ├─php(19904)
           ├─php(19905)
           ├─php(19906)
           ├─php(19907)
           ├─php(19908)
           ├─php(19909)
           └─php(19910)

```

## 建表语句

```mysql

CREATE TABLE `house` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_general_ci NOT NULL DEFAULT '',
  `address` varchar(255) COLLATE utf8mb4_general_ci NOT NULL DEFAULT '',
  `square` varchar(255) COLLATE utf8mb4_general_ci NOT NULL DEFAULT '',
  `direction` varchar(255) COLLATE utf8mb4_general_ci NOT NULL DEFAULT '',
  `house_type` varchar(255) COLLATE utf8mb4_general_ci NOT NULL DEFAULT '',
  `price` decimal(10,2) NOT NULL DEFAULT '0.00',
  `created_at` timestamp NOT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

```
