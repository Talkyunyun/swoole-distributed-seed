<?php
/**
 * 发送邮件
 * @author: Gene
 */
namespace app\Utils;


class EmailUtil {
    // 邮件配置
    private $emailConfig;


    public function __construct() {
        $this->emailConfig = get_instance()->config->get('email');
    }


    /**
     * 单次发送邮件
     * @param $toEmail
     * @param $subject
     * @param $body
     * @return bool
     */
    public function send($toEmail, $subject, $body) {
        $mail = new \PHPMailer();

        $mail->isSMTP();
        $mail->isHTML(true);
        $mail->Host       = $this->emailConfig['host'];
        $mail->Username   = $this->emailConfig['username'];
        $mail->Password   = $this->emailConfig['password'];
        $mail->Port       = $this->emailConfig['port'];
        $mail->SMTPAuth   = true;
        $mail->SMTPSecure = 'tls';

        $mail->setFrom($this->emailConfig['username'], $this->emailConfig['name']);
        $mail->addAddress($toEmail);
        $mail->Subject = $subject;
        $mail->Body    = $body;

        if ($mail->send()) {
            return true;
        }

        // $mail->ErrorInfo;
        return false;
    }
}