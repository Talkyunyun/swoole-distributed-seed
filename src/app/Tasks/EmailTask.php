<?php
/**
 * 发送邮件任务
 * @author: Gene
 */

namespace app\Tasks;

use app\Utils\EmailUtil;
use app\Utils\LogUtil;

class EmailTask extends BaseTask {

    // redis发送邮件列表主键
    private $_send_email_key = 'send_mail_task';

    // 邮件发送失败列表
    private $_send_email_fail_key = 'send_mail_fail';

    /**
     * 定时发送邮件任务
     * @return \Generator
     */
    public function sendEmail() {
        $logger = LogUtil::getLogger('email');
        try {
            $uids = yield $this->_getQueue();
            if (empty($uids)) {
                print_r('没有需要发送的邮件' . PHP_EOL);

                return false;
            }

            foreach ($uids as $uid) {
                // TODO 数据库获取信息
                $email = '729170207@qq.com';
                if (!(new EmailUtil)->send($email, '测试标题', '测试内容')) {
                    // 发送失败压入队列
                    yield $this->_sendFail($uid);
                }
            }

            $logger->info('发送成功', []);
            print_r('执行完成:');
        } catch (\Exception $e) {
            $logger->error('发送失败:', [
                'errorMsg'  => $e->getMessage(),
                'errorFile' => $e->getFile(),
                'fileLine'  => $e->getLine()
            ]);

            print_r('发送失败,错误原因:' . $e->getMessage());
        }
    }

    /**
     * 压入发送失败入队列
     * @param $uid
     * @return bool|\Generator
     */
    private function _sendFail($uid) {
        $key = $this->_send_email_fail_key;
        $list = yield $this->redis_pool->getCoroutine()->lGetRange($key, '0', '-1');
        if (in_array($list, $uid)) {
            return false;
        }

        return yield $this->redis_pool->getCoroutine()->lPush($key, $uid);
    }

    /**
     * 获取待发UID,最多30
     * @return array|bool
     */
    private function _getQueue() {
        $len = yield (int)$this->redis_pool->getCoroutine()->lLen($this->_send_email_key);
        if (empty($len)) {
            return false;
        }

        $data = [];
        for ($i = 30; $i > 0; $i--) {
            $uid = yield $this->redis_pool->getCoroutine()->rPop($this->_send_email_key);
            array_push($data, $uid);
        }

        return $data;
    }
}