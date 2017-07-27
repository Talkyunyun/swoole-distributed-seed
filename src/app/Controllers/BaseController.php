<?php
/**
 * 控制器基类
 * User: gene
 * Date: 2017/7/26
 * Time: 下午5:16
 */

namespace app\Controllers;

use Server\CoreBase\Controller;
use Server\CoreBase\XssClean;

class BaseController extends Controller {

    /**
     * 获取GET请求参数
     * @param string $name
     * @param string $default
     * @param bool $xssClean
     * @return array|bool|string
     */
    protected function get($name = '', $default = '', $xssClean = true) {
        if (empty($name)){
            if ($xssClean){
                return XssClean::getXssClean()->xss_clean($this->http_input->request->get ?? '');
            }

            return $this->http_input->request->get;
        }

        $value = $this->http_input->get($name, $xssClean);
        if ($value === '' && $default){
            $value = $default;
        }

        return $value;
    }


    /**
     * 获取POST请求参数
     * @param string $name
     * @param string $default
     * @param bool $xssClean
     * @return array|bool|string
     */
    protected function post($name = '', $default = '', $xssClean = true) {
        if (empty($name)){
            if ($xssClean){
                return XssClean::getXssClean()->xss_clean($this->http_input->request->post ?? '');
            }

            return $this->http_input->request->post;
        }

        $value = $this->http_input->post($name, $xssClean);
        if ($value === '' && $default){
            $value = $default;
        }

        return $value;
    }


    // 是否POST请求
    protected function isPost() {
        return strtoupper($this->request->server['request_method']) == 'POST' ? true : false;
    }


    // 是否GET请求
    protected function isGet() {
        return strtoupper($this->request->server['request_method']) == 'GET' ? true : false;
    }

    // 是否AJAX请求
    protected function isAjax() {
        if (
            isset($this->request->header['x-requested-with']) &&
            $this->request->header['x-requested-with'] == 'XMLHttpRequest'
        ) {
            return true;
        }

        return false;
    }
}