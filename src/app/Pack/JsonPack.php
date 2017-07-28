<?php
/**
 * 自定义数据协议  TCP  WebSocket
 * @author: Gene
 */

namespace app\Pack;

use app\Route\NormalRoute;
use Server\CoreBase\SwooleException;
use Server\Pack\IPack;

class JsonPack implements IPack {

    // 打包
    public function pack($data) {
        return json_encode($data, JSON_UNESCAPED_UNICODE);
    }

    // 解包
    public function unPack($data) {
        $data = json_decode($data);
        if (empty($data)) {
            throw new SwooleException('解包出错');
        }

        (new NormalRoute())->handleClientData($data);

        return $data;
    }
}