<?php
/**
 * Consul配置
 * @author: Gene
 */

// 是否启用consul
$config['consul']['enable'] = false;

// node的名字，每一个都必须不一样
$config['consul']['node_name'] = 'SD-1';

// 服务器名称，同种服务应该设置同样的名称，用于leader选举
$config['consul']['leader_service_name'] = 'Test';

// consul的data_dir默认放在临时文件下
$config['consul']['data_dir'] = "/tmp/consul";

// consul join地址，可以是集群的任何一个，或者多个
$config['consul']['start_join'] = ["192.168.8.85"];

// 本地网卡地址
$config['consul']['bind_addr'] = "192.168.8.57";

// 监控服务
$config['consul']['watches'] = ['MathService'];

// 发布服务
// $config['consul']['services']=['MathService'];


return $config;