<?php
/**
 * 数据库配置
 * @author: Gene
 */

$config['mysql'] = [
    // 本地数据库
    'local' => [
        'host'      => '127.0.0.1',
        'port'      => 3306,
        'charset'   => 'utf8',
        'user'      => 'root',
        'password'  => 'root',
        'database'  => 'test',
        'prefix'    => 'a_'
    ],
    // 测试数据库
    'dev' => [
        'host'      => '127.0.0.1',
        'port'      => 3306,
        'charset'   => 'utf8',
        'user'      => 'root',
        'password'  => 'root',
        'database'  => 'test',
        'prefix'    => 'a_'
    ]
];


$config['mysql']['enable'] = true;
$config['mysql']['asyn_max_count'] = 10;
$config['mysql']['active'] = 'local';

return $config;