<?php
$orderJson = json_encode($_POST);
$appSecret = YOUR_APP_SECRET;

$sign = $_POST['sign'];
$arr = $_POST;
unset($arr['sign']);
ksort($arr);

foreach ($arr as $key => $value) {
	$params[] = $key . '=' . $value;
}
$str = implode("&", $params);

$mySign = md5($str . YOUR_APP_SECRET);
if ($sign == $mySign) {
	$ret = 1;
	echo "OK";
} else {
	$ret = 0;
	echo "FAIL";
}

error_log(date("Y-m-d H:i:s") . "\t" . $orderJson . "\t" . $ret . "\n", 3, '/data/logs/php/wx_back.log');
