<?php
/**
 * WebSocket服务 DEMO
 * User: gene
 * Date: 2017/7/26
 * Time: 下午5:16
 */

namespace app\Controllers;

use Server\CoreBase\Controller;

class WebSocket extends Controller {

    // 用户信息key
    private $user_info_key = 'user_info_';

    // 初始化信息
    public function init() {
        $uid = (int)$this->client_data->uid;

        // 1、存入用户信息到redis中
        $user = yield $this->_getUser($uid);
        if (empty($user) || count($user) <= 0) {
            $this->send([
                'msg'  => '不存在该用户信息',
                'type' => 'system'
            ]);
            return false;
        }

        // 2、绑定用户
        $this->bindUid($this->fd, $uid);

        // 通知
        $this->send([
            'msg' => '初始化成功',
            'type'=> 'system',
            'user'=> $user
        ]);
    }

    // 加入房间
    public function join() {
        $roomId = (int)$this->client_data->room_id;

        // 把当前用户加入到房间中
        $this->addToGroup($this->uid, $roomId);

        // 更新用户信息
        $user = yield $this->_getUser($this->uid, [
            'room_id' => $roomId
        ]);

        $data = [
            'msg'    => '我们倡导绿色聊天',
            'type'   => 'system',
            'action' => 'join',
            'user'   => $user
        ];

        // 通知当前客户端
        $this->send($data, false);

        // 通知其他人
        $this->sendToGroup($roomId, [
            'msg'   => '用户加入房间',
            'type'  => 'system',
            'user'  => $user
        ]);
    }


    // 发送消息
    public function message() {
        $msg = $this->client_data->msg;
        $user = yield $this->_getUser($this->uid);

        $this->sendToGroup($user['room_id'], [
            'msg'  => $msg,
            'type' => 'user',
            'user' => $user
        ]);
    }

    // 离开房间
    public function leave() {
        $user = yield $this->_getUser($this->uid);

        $this->sendToGroup($user['room_id'], [
            'msg' => '用户离开房间',
            'type'=> 'system'
        ], false);

        $this->removeFromGroup($user['id'], $user['room_id']);
        $this->destroy();
    }


    /**
     * 获取用户信息,并存入缓存
     * @param int $uid
     * @param array $data
     * @return bool|\Generator
     */
    private function _getUser($uid = 0, $data = false) {
        $uid = intval($uid);
        if (empty($uid)) return false;

        $key   = $this->user_info_key . $uid;
        $redis = $this->redis_pool->getCoroutine();

        if (!yield $redis->exists($key)) {
            $userm = $this->loader->model('UsersModel', $this);
            $user  = yield $userm->getOne([
                'id' => $uid
            ]);

            if ($data && is_array($data)) {
                $user = array_merge($user, $data);
            }

            yield $redis->hMset($key, $user);
        }

        $user = yield $redis->hGetAll($key);
        if ($data && is_array($data)) {
            $user = array_merge($user, $data);
            yield $redis->hMset($key, $user);
        }

        return yield $redis->hGetAll($key);
    }
}