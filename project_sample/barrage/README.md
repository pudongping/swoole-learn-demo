# 视频弹幕

> [直播源相关资源汇总](https://github.com/imDazui/Tvlist-awesome-m3u-m3u8)

## 直播格式

- rtmp 协议格式直播地址：  
rtmp://202.69.69.180:443/webcast/bshdlive-pc

- hls 协议格式直播地址：  
http://ivi.bupt.edu.cn/hls/cctv6hd.m3u8  
http://ivi.bupt.edu.cn/hls/cctv1hd.m3u8  
http://ivi.bupt.edu.cn/hls/cctv5phd.m3u8  

## web 播放器

- [LivePlayer H5 播放器](https://www.liveqing.com/docs/manuals/LivePlayer.html)  
- [DPlayer 带弹幕的播放器](http://dplayer.js.org/zh)


## 安装

> 要想完整安装所有的插件包的话，可以执行下面的安装命令，当然也可以不用安装，本项目已经将主要用到的 js 文件下载到本地了。

```shell

# 首先需要安装 dplayer
npm install dplayer --save

# 因为要用到 hls 格式，因此需要安装 hls.js
npm install --save hls.js 

```

## 启动

### 服务端

```shell

root@dc705af7d5da:/var/www/swoole-learn-demo/project_sample/barrage# php server.php
connection open: 1
connection open: 2

```

### 客户端

直接在浏览器中访问 `index.html` 文件即可。
