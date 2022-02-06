<?php
/**
 * 简单的客服聊天系统
 *
 * Created by PhpStorm
 * User: Alex
 * Date: 2021-10-04 17:53
 * E-mail: <276558492@qq.com>
 */
declare(strict_types=1);

use Swoole\WebSocket\Server;

// 初始化 WebSocket 服务器，在本地监听 5200 端口
$server = new Server('0.0.0.0', 5200);

// 假定用户的 token 和用户的 id 对应的关联关系如下
$userTokens = [
    'user_token_1' => 1,
];
$adminTokens = [
    'admin_token_1' => 1
];
$redisCfg = [
    'host' => '172.28.0.2',
    'port' => 6379
];
$users = [
    1 => [
        'id' => 1,
        'name' => '用户1',
    ],
];
$admins = [
    1 => [
        'id' => 1,
        'name' => '客服1',
    ],
];

// 建立连接时触发
$server->on('open', function (Server $server, $request) use ($userTokens, $adminTokens, $redisCfg) {
    $get = $request->get;

    if ('user' == $get['type']) {
        $id = $userTokens[$get['token']];
    } else { // type 为 admin
        $id = $adminTokens[$get['token']];
    }

    $redis = new Swoole\Coroutine\Redis;  // 启动协程 redis 必须要在协程环境下
    $redis->connect($redisCfg['host'], $redisCfg['port']);
    $hashfd = 'im_database:' . $get['type'] . '_fd_to_id';
    $hashId = 'im_database:' . $get['type'] . '_id_to_fd';
    $redis->hSet($hashfd, (string)$request->fd, (string)$id);  // 存储 fd 和 id 之间的关系
    $redis->hSet($hashId, (string)$id, (string)$request->fd);  // 存储 id 和 fd 之间的关系

    echo "server: handshake success with fd{$request->fd}\n";
});

// 收到消息时触发推送
$server->on('message', function (Server $server, $frame) use ($redisCfg, $users, $admins) {
    echo "receive from {$frame->fd}:{$frame->data},opcode:{$frame->opcode},fin:{$frame->finish}\n";

    // 这里接收到消息
    $data = json_decode($frame->data, true);
    // 先判断事件，如果是心跳事件，则不做任何处理
    if ('heart_beat' == $data['event']) {
        $server->push($frame->fd, json_encode([
            'code' => 200,
            'msg' => 'pong',
            'data' => ''
        ], 256));
        return;
    }
    // 如果是客服聊天事件的话
    if ('service_chat' == $data['event']) {
        // 先找到自己的 id 是多少
        $redis = new Swoole\Coroutine\Redis;  // 启动协程 redis 必须要在协程环境下
        $redis->connect($redisCfg['host'], $redisCfg['port']);

        $myType = 'admin' == $data['receiver']['type'] ? 'user' : 'admin';  // 发送者和接受者类型是互斥的
        $hashfd = 'im_database:' . $myType . '_fd_to_id';
        $myId = $redis->hGet($hashfd, (string)$frame->fd);  // 通过 fd 取出自己的 id
        $myInfo = ('user' == $myType ? $users : $admins)[$myId];  // 取出自己的用户信息

        // 取出消息接受者相关的信息
        $hashId = 'im_database:' . $data['receiver']['type'] . '_id_to_fd';
        $receiverFd = $redis->hGet($hashId, (string)$data['receiver']['id']) ?: 0;  // 通过消息接收者的 id 取出消息接收者的 fd
        $receiverInfo = ('user' == $data['receiver']['type'] ? $users : $admins)[($data['receiver']['id'])];  // 消息接收者的用户信息

        // 这里可以将消息内容存入到 mysql 数据库中，这里只做演示，故暂时不存
        if ('user' == $myType) {
            $userInfo = $myInfo;
        } else {
            $userInfo = $receiverInfo;
        }
        if ('admin' == $myType) {
            $adminInfo = $myInfo;
        } else {
            $adminInfo = $receiverInfo;
        }

        // 消息发送
        $sendMsg = [
            'code' => 200,
            'msg' => 'success',
            'data' => [
                'id' => $frame->fd,
                'send_user_type' => ('user' == $myType ? 1 : 2),
                'send_time' => date('Y-m-d H:i:s'),
                'content' => $frame->data,  // 消息内容
                'user' => $userInfo,
                'admin' => $adminInfo
            ],
        ];

        // 检查连接是否为有效的 websocket 客户端连接
        if ($server->isEstablished((int)$receiverFd)) {
            $server->push((int)$receiverFd, json_encode($sendMsg, 256));
        }

        // 消息通知自己
        $server->push($frame->fd, json_encode($sendMsg, 256));

    }

});

// 关闭 WebSocket 连接时触发
$server->on('close', function ($ser, $fd) {
    echo "client {$fd} closed\n";
});

// 启动 WebSocket 服务器
$server->start();
