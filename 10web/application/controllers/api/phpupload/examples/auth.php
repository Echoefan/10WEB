<?php
require_once __DIR__ . '/../autoload.php';

use Qiniu\Auth;

// 用于签名的公钥和私钥. http://developer.qiniu.com/docs/v6/api/overview/security.html#aksk
$accessKey = 'KIQHMOpJhhTwrTt4BX_L0FyCbw7B_s0vIJGz6Acb';
$secretKey = 'VFdB25SBNfcAjGkeqE4qRdsYI01FNo1It6M-XfB4';

// 初始化签权对象。
$auth = new Auth($accessKey, $secretKey);
