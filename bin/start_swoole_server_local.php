<?php
/**
 * 本地启动脚本
 * @author: Gene
 */

require_once 'define.php';
$worker = new \app\AppServer();
Server\Start::run();