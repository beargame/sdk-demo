<?php
$orderJson = json_encode($_POST);

$sign = $_POST['sign'];

$arr = $_POST;
unset($arr['sign']);
ksort($arr);
$mySign = md5(http_build_query($arr) . "b3ad67fa6b25d435d4dd12896005428f");
if ($sign == $mySign) {
	$ret = 1;
} else {
	$ret = 0;
}

error_log(date("Y-m-d H:i:s") . "\t" . $orderJson . "\t" . $ret . "\n", 3, '/data/logs/php/wx_back.log');
echo "OK";