## Seed for Swoole Distributed

#### 安装流程
1、源码安装
```
git clone https://github.com/tmtbe/SwooleDistributed.git

cd SwooleDistributed
composer install

php ./src/Install.php
```


2、Composer安装  
建立composer.json如下，可以根据需要添加你所依赖的库，但下面一定得包含在内，autoload必须要指定app和test的目录不得省略。
```json
{
  "require": {
    "tmtbe/swooledistributed":">2.0.0"
  },
 "autoload": {
    "psr-4": {
      "app\\": "src/app",
      "test\\": "src/test"
    }
  }
}
```

```bash
# 安装依赖
composer install

# 运行脚手架工具安装框架
php vendor/tmtbe/swooledistributed/src/Install.php
```


#### 服务运行相关
```bash
# 调试模式启动
php start_swoole_server.php start

# 守护进程启动
php start_swoole_server.php start -d

# 重启,结束当前进程,重新启动新进程
php start_swoole_server.php restart

# 重载 不会断开客户端链接,进行代码重载,客户端无感知
php start_swoole_server.php reload

# 停止服务器
php start_swoole_server.php stop

# 强杀
php start_swoole_server.php kill

```