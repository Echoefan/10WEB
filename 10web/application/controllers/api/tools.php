<?php
//this php file is used to center the tool function which will be used

/**
 * use to send email to user
 *
 * @param string $account -the email address
 * @param string $email_info -thie email info
 * @param string $base_url -the website base url
 */
function sendMail($account,$email_info,$base_url = "localhost:6070"){

    require("phpmailer/class.phpmailer.php");
    require("emailHtml/Verification.php");

    $email_host = $email_info['email_host'];
    $email_username = $email_info['email_username'];
    $email_password = $email_info['email_password'];

    $mail = new PHPMailer(); //建立邮件发送类
    $address = $account;
    $mail->IsSMTP(); // 使用SMTP方式发送
    $mail->Host = $email_host; // 您的企业邮局域名
    $mail->SMTPAuth = true; // 启用SMTP验证功能
    $mail->Username = $email_username; // 邮局用户名(请填写完整的email地址)
    $mail->Password = $email_password; // 邮局密码
    $mail->From = $email_username; //邮件发送者email地址
    $mail->FromName = "亿灵";
    $mail->AddAddress("$address", "$address");

    //收件人地址，可以替换成任何想要接收邮件的email信箱,格式是AddAddress("收件人email","收件人姓名")
    $mail->Subject = "eling验证"; //邮件标题：要以英文开头
    $_account = urlencode(base64_encode($account));

    //the url input
    $msg = sprintf("%s/index.php/user/activeUser/%s",$base_url,$_account);
    $web_url = $base_url;    
    //the function is used to format a html verifcation html email
    $msg = getVerifi($msg,$web_url);

    //set the content to be html ,not only the text
    $mail->IsHtml(true);
    $mail->Body = $msg; //邮件内容
    return $mail->Send();
}

// 2017-4-11修改 添加了文件上传功能(从服务器上传至七牛云)

 require 'phpupload/autoload.php';
    
     // 引入鉴权类
    use Qiniu\Auth;

    // 引入上传类
    use Qiniu\Storage\UploadManager;

/**
 * use to upload file to qiniu
 *
 * @param string $filePath -要上传文件的本地路径
 * @param string $key -上传到七牛后保存的文件名
 */
function fileUpload($filePath,$key){
   
    // 需要填写你的 Access Key 和 Secret Key
    $accessKey = 'KIQHMOpJhhTwrTt4BX_L0FyCbw7B_s0vIJGz6Acb';
    $secretKey = 'VFdB25SBNfcAjGkeqE4qRdsYI01FNo1It6M-XfB4';

    // 构建鉴权对象
    $auth = new Auth($accessKey, $secretKey);

    // 要上传的空间
    $bucket = 'nk-e0';

    // 生成上传 Token
    $token = $auth->uploadToken($bucket);

    // 初始化 UploadManager 对象并进行文件的上传。
    $uploadMgr = new UploadManager();

    // 调用 UploadManager 的 putFile 方法进行文件的上传。
    list($ret, $err) = $uploadMgr->putFile($token, $key, $filePath);
    echo "\n====> putFile result: \n";
    if ($err !== null) {
        var_dump($err);
    } else {
        var_dump($ret);
    }
}

?>
