<?php
/**
 * 任务案例
 * @author: Gene
 */

namespace app\Tasks;

use app\Utils\LogUtil;

class DemoTask extends BaseTask {

    public function testTask() {
        // 1、操作redis案例  同redis扩展对象API
        yield $this->redis_pool->getCoroutine()->set('name', 'genedd');

        $data['data'] = 'dadsdf';
        $data['create_time'] = time();

        // 2、操作mysql案例
        $model    = $this->loader->model('TaskDataModel', $this);
        $insertId = yield $model->insert($data);

        $data['id'] = $insertId;
        $logger = LogUtil::getLogger();
        $logger->info('Mysql数据信息', $data);

        print_r("操作成功: \r\n");
    }
}