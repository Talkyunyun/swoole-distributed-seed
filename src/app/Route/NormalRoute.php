<?php
/**
 * 自定义路由器
 * @author: Gene
 */

namespace app\Route;

use Server\Route\IRoute;

class NormalRoute implements IRoute {
    private $client_data;

    public function __construct() {
        $this->client_data = new \stdClass();
    }

    /**
     * TCP 设置反序列化后的数据 Object
     * @param $data
     * @return \stdClass
     */
    public function handleClientData($data) {
        $this->client_data = $data;
        return $this->client_data;
    }

    /**
     * HTTP 处理http request
     * @param $request
     */
    public function handleClientRequest($request) {
        $this->client_data->path = $request->server['path_info'];
        $route = explode('/', $request->server['path_info']);
        $this->client_data->controller_name = $route[1] ?? null;
        $this->client_data->method_name = $route[2] ?? null;
    }

    /**
     * 获取控制器名称
     * @return string
     */
    public function getControllerName() {
        return $this->client_data->controller_name;
    }

    /**
     * 获取方法名称
     * @return string
     */
    public function getMethodName() {
        return $this->client_data->method_name;
    }

    // HTTP
    public function getPath() {
        return $this->client_data->path;
    }

    // TCP
    public function getParams() {
        return $this->client_data->params??null;
    }
}