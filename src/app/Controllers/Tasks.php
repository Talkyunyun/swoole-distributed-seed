<?php
namespace app\Controllers;

use Server\CoreBase\Controller;

class Tasks extends Controller {

    public function http_test() {
        // 控制台输出内容
        print_r("dddddd");
    }


    // 任务测试
    public function http_test_task() {
        $demoTask = $this->loader->task('DemoTask');
        $demoTask->test();

        $demoTask->startTask(function ($serv, $task_id, $data) {
            $this->http_output->end($data);
        });
    }
}