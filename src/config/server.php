<?php
/**
 * 服务启动配置信息
 * @author: Gene
 */

// http服务器配置信息
$config['http_server']['enable'] = true;
$config['http_server']['socket'] = '0.0.0.0';
$config['http_server']['port'] = 8081;

// websocket配置信息
$config['websocket']['enable'] = true;
// WEBSOCKET_OPCODE_TEXT = 0x1; // UTF-8文本字符数据
// WEBSOCKET_OPCODE_BINARY = 0x2; // 二进制数据
$config['websocket']['opcode'] = WEBSOCKET_OPCODE_TEXT;


// tcp配置信息
$config['tcp']['enable'] = true;
$config['tcp']['socket'] = '0.0.0.0';
$config['tcp']['port'] = 9093;


// 服务器配置
$config['server']['dispatch_port'] = 9991;
$config['server']['dispatch_udp_port'] = 9992;
$config['server']['send_use_task_num'] = 20;
// 封装器处理类  \Server\Pack\JsonPack
$config['server']['pack_tool'] = 'JsonPack';
// 路由器处理类  \Server\Route\NormalRoute
$config['server']['route_tool'] = 'NormalRoute';



$config['server']['set'] = [
    'log_file' => LOG_DIR."/swoole.log",
    'log_level' => 5,
    'reactor_num' => 2, //reactor thread num
    'worker_num' => 4,    //worker process num
    'backlog' => 128,   //listen backlog
    'open_tcp_nodelay' => 1,
    'dispatch_mode' => 5,
    'task_worker_num' => 5,
    'task_max_request' => 5000,
    'enable_reuse_port' => true,
    'heartbeat_idle_time' => 120,//2分钟后没消息自动释放连接
    'heartbeat_check_interval' => 60,//1分钟检测一次
];

// 配置TCP WebSocket协议头
$config['server']['probuf_set'] = [
    'open_length_check' => 1,
    'package_length_type' => 'N',
    'package_length_offset' => 0,       //第N个字节是包长度的值
    'package_body_offset' => 0,       //第几个字节开始计算长度
    'package_max_length' => 2000000,  //协议最大长度)
];


//协程超时时间
$config['coroution']['timerOut'] = 5000;

//是否启用自动reload
$config['auto_reload_enable'] = true;


return $config;