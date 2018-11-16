<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件
function postmail($to,$subject = '',$body = ''){
    //Author:Jiucool WebSite: http://www.jiucool.com
    //$to 表示收件人地址 $subject 表示邮件标题 $body表示邮件正文
    //error_reporting(E_ALL);
    //require_once('class.phpmailer.php');
    \think\Loader::import('PHPMailer.PHPMailer');
    $mail             = new PHPMailer(); //new一个PHPMailer对象出来
    //$body            = eregi_replace("[\]",'',$body); //对邮件内容进行必要的过滤
    $mail->CharSet ="UTF-8";//设定邮件编码，默认ISO-8859-1，如果发中文此项必须设置，否则乱码
    $mail->IsSMTP(); // 设定使用SMTP服务
    $mail->SMTPDebug  = 1;                     // 启用SMTP调试功能
    // 1 = errors and messages
    // 2 = messages only
    $mail->SMTPAuth   = true;                  // 启用 SMTP 验证功能
    $mail->Host       = 'smtp.163.com';      // SMTP 服务器
    $mail->Port       = 25;                   // SMTP服务器的端口号
    $mail->Username   = '18174080464';  // SMTP服务器用户名，PS：我乱打的
    $mail->Password   = 'chen123456';            // SMTP服务器密码
    $mail->SetFrom('18174080464@163.com', '陈豆');
    $mail->Subject    = $subject;
    $mail->MsgHTML($body);
    $mail->AddAddress($to);
    $mail->Send();
    /* if(!$mail->Send()) {
        echo 'Mailer Error: ' . $mail->ErrorInfo;
    } else {
        echo "Message sent!恭喜，邮件发送成功！";
    } */
}
?>