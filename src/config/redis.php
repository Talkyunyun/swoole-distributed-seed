<?php
/**
 * Redis环境配置
 * @author: Gene
 */

$config['redis'] = [
    // 本地环境
    'local' => [
        'ip'        => '127.0.0.1',
        'port'      => 6379,
        'select'    => 1,
        'password'  => 'redis'
    ],
    // 开发环境
    'dev' => [
        'ip'        => '127.0.0.1',
        'port'      => 6379,
        'select'    => 1,
        'password'  => 'redis'
    ],
    // dispatch使用的环境 这个不要删除，dispatch使用的redis环境
    'dispatch' => [
        'ip'        => 'unix:/var/run/redis/redis.sock',
        'port'      => 0,
        'select'    => 1,
        'password'  => 'redis'
    ]
];

$config['redis']['enable'] = true;
$config['redis']['asyn_max_count'] = 10;
$config['redis']['active'] = 'local';

return $config;
