<?php
/**
 * Http 服务案例
 * User: gene
 * Date: 2017/7/26
 * Time: 下午5:16
 */

namespace app\Controllers;

class Http extends BaseController {

    /**
     * 测试方法
     * http://localhost:8081/HttpController/test
     */
    public function http_test() {
        // $data = $this->http_input->get();
        // $data = $this->http_input->post();

        // $table = TaskDataModel::tableName();

        // 控制台输出内容
        // print_r("dddddd" . $table);


        // 返回浏览器内容
        $this->http_output->end('gene ddddd');
    }


    // 发送邮件
    public function http_send_email() {
        $mail = new \PHPMailer();

        $mail->isSMTP();
        $mail->Host       = 'smtp.sina.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'yunyun201414@sina.com';
        $mail->Password   = 'Lovexx0930#@!';
        $mail->SMTPSecure = 'tls';
        $mail->Port       = 25;


        $mail->setFrom('yunyun201414@sina.com', '杨云');
        $mail->addAddress('729170207@qq.com', 'Gene');
        $mail->Subject = '我是标题';
        $mail->Body = '我是内容';

        if (!$mail->send()) {
            $this->http_output->end('发送失败:' . $mail->ErrorInfo);
        } else {
            $this->http_output->end('发送成功');
        }
    }
}