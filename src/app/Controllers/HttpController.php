<?php
/**
 * Http 服务案例
 * User: gene
 * Date: 2017/7/26
 * Time: 下午5:16
 */

namespace app\Controllers;

use app\Models\BaseModel;
use app\Models\TaskDataModel;
use Server\CoreBase\Controller;

class HttpController extends Controller {

    /**
     * 测试方法
     * http://localhost:8081/HttpController/test
     */
    public function http_test() {
        // $data = $this->http_input->get();
        // $data = $this->http_input->post();

        $table = TaskDataModel::tableName();

        // 控制台输出内容
        print_r("dddddd" . $table);


        // 返回浏览器内容
        $this->http_output->end('gene test');
    }
}