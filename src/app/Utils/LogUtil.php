<?php
/**
 * 日志操作对象
 * @author: Gene
 */
namespace app\Utils;

use Monolog\Logger;
use Monolog\Handler\RotatingFileHandler;

class LogUtil {

    /**
     * 获取日志操作对象  按时间存放
     * @param string $fileName
     * @return mixed
     */
    public static function getLogger($fileName = 'run') {
        static $loggers;
        if (empty($fileName)) {
            $fileName = 'run';
        }

        if (!isset($loggers[$fileName])) {
            $logConfig = get_instance()->config->get('log');
            $filePath  = $logConfig['file']['log_path'] . $fileName . '.log';
            $maxFiles  = $logConfig['file']['log_max_files'];

            $loger = new Logger($fileName);
            $loger->pushHandler(new RotatingFileHandler($filePath, $maxFiles, Logger::INFO));
            $loggers[$fileName] = $loger;
        }

        return $loggers[$fileName];
    }
}