<?php
/**
 * 定时器任务配置
 * @author: Gene
 */


/**
 * timerTask定时任务
 * （选填）task名称 task_name
 * （选填）model名称 model_name  task或者model必须有一个优先匹配task
 * （必填）执行task的方法 method_name
 * （选填）执行开始时间 start_time,end_time) 格式： Y-m-d H:i:s 没有代表一直执行,一旦end_time设置后会进入1天一轮回的模式
 * （必填）执行间隔 interval_time 单位： 秒
 * （选填）最大执行次数 max_exec，默认不限次数
 * （选填）是否立即执行 delay，默认为false立即执行
 */
//dispatch发现广播，实现集群的实现
$config['timerTask'][] = [
    'task_name'     => 'UdpDispatchTask',
    'method_name'   => 'send',
    'interval_time' => '30'
];



// 定时测试任务,1秒执行一次
//$config['timerTask'][] = [
//    'task_name'     => 'DemoTask',
//    'method_name'   => 'testTask',
//    'start_time' => 'Y-m-d 00:00:00',
//    'end_time' => 'Y-m-d 23:00:00',
//    'interval_time' => '2'
//];

// 定时发送邮件任务,5秒执行一次
//$config['timerTask'][] = [
//    'task_name'     => 'EmailTask',
//    'method_name'   => 'sendEmail',
//    'start_time'    => 'Y-m-d 00:00:00',
//    'end_time'      => 'Y-m-d 23:59:59',
//    'interval_time' => 2
//];



return $config;