<?php
require_once __DIR__ . '/../autoload.php';

use Qiniu\Auth;
use Qiniu\Storage\BucketManager;

$accessKey = 'KIQHMOpJhhTwrTt4BX_L0FyCbw7B_s0vIJGz6Acb';
$secretKey = 'VFdB25SBNfcAjGkeqE4qRdsYI01FNo1It6M-XfB4';

$auth = new Auth($accessKey, $secretKey);
$bmgr = new BucketManager($auth);

$url = 'http://php.net/favicon.ico';
$bucket = 'nk-e0';
$key = time() . '.ico';

list($ret, $err) = $bmgr->fetch($url, $bucket, $key);
echo "=====> fetch $url to bucket: $bucket  key: $key\n";
if ($err !== null) {
    var_dump($err);
} else {
    echo 'Success';
}
