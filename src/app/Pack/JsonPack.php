<?php
/**
 * 自定义封装器  TCP  WebSocket
 * @author: Gene
 */

namespace app\Pack;

use Server\CoreBase\SwooleException;
use Server\Pack\IPack;

class JsonPack implements IPack {

    // 打包
    public function pack($data) {
        return json_encode($data, JSON_UNESCAPED_UNICODE);
    }

    // 解包
    public function unPack($data) {
        $value = json_decode($data);
        if (empty($value)) {
            throw new SwooleException('json unPack 失败');
        }

        return $value;
    }
}