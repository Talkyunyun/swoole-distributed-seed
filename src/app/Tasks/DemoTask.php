<?php
/**
 * 任务案例
 * @author: Gene
 */

namespace app\Tasks;


use app\Utils\LogUtil;
use Server\CoreBase\Task;

class DemoTask extends Task {

    public function testTask() {
        $model = $this->loader->model('TaskDataModel', $this);
        $table = $model->getOne([
            'id' => 2
        ]);

        print_r($table);

        $logger = LogUtil::getLogger();
        $logger->info('看书记得返款');


        print_r("类型: \r\n");
    }
}