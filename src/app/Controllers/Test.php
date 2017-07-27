<?php
/**
 * 测试控制器
 * User: gene
 * Date: 2017/7/26
 * Time: 下午5:16
 */

namespace app\Controllers;


class Test extends BaseController {

    public function http_get() {
        $name = $this->get('name', '我是默认值');

        $this->http_output->end($name);
    }

    public function http_post() {
        if (!$this->isPost()) {
            $this->http_output->end('非法请求');
        }

        $name = $this->post('name', 'gene');

        $this->http_output->end($name);
    }
}