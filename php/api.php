<?php
$open = new BearOpen();
$open->secret = "b3ad67fa6b25d435d4dd12896005428f";
// $accessToken = "sasd1213123";
// $open->UserInfo($accessToken); //获取用户信息
$open->SetGameUrl("http://g.ibingyi.com/ext.html"); //设置游戏地址
$open->SetNotifyUrl("http://g.ibingyi.com/back.php"); //设置支付回调地址
$json = '[{"id":1001,"price":100,"name":"10元宝","desc":"10元宝"},{"id":1002,"price":200,"name":"20元宝","desc":"20元宝"}]'; //设置支付套餐
$open->SetProduct($json);
$openId = "7da288c4449afddda7862d6f684a05e3";
$open->AddWhite($openId); //添加支付白名单ID

class BearOpen {
	public $secret;

	public function UserInfo($accessToken) {
		$url = "http://g.ibingyi.com/open/UserInfo?accessToken=" . $accessToken;
		$this->httpRequest($url, "get", array());
	}

	public function SetProduct($json) {
		$params = array(
			'appId' => 1,
			'data' => $json,
		);

		$sign = $this->makeSign($params);
		$params['sign'] = $sign;
		$url = "http://g.ibingyi.com/open/setProduct";
		$this->httpRequest($url, "post", $params);
	}

	public function AddWhite($openId) {
		$params = array(
			'appId' => 1,
			'data' => $openId,
		);

		$sign = $this->makeSign($params);
		$params['sign'] = $sign;
		$url = "http://g.ibingyi.com/open/AddWhite";
		$this->httpRequest($url, "post", $params);
	}

	public function SetNotifyUrl($url) {
		$params = array(
			'appId' => 1,
			'data' => $url,
		);

		$sign = $this->makeSign($params);
		$params['sign'] = $sign;
		$url = "http://g.ibingyi.com/open/SetNotifyUrl";
		$this->httpRequest($url, "post", $params);
	}

	public function SetGameUrl($gameUrl) {
		$params = array(
			'appId' => 1,
			'data' => $gameUrl,
		);

		$sign = $this->makeSign($params);
		$params['sign'] = $sign;
		$url = "http://g.ibingyi.com/open/SetGameUrl";
		$this->httpRequest($url, "post", $params);
	}

	private function httpRequest($url, $method = "get", $post_string) {
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
		curl_setopt($ch, CURLOPT_TIMEOUT, 10);
		curl_setopt($ch, CURLOPT_HEADER, false);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_USERAGENT, 'ibingyi');

		if ($method == 'post') {
			curl_setopt($ch, CURLOPT_POST, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $post_string);
		}

		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Expect:'));
		$res = curl_exec($ch);
		$err = curl_error($ch);
		$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		curl_close($ch);

		var_dump($http_code);
		var_dump($res);
	}

	private function makeSign($params) {
		ksort($params);
		$sign = md5(http_build_query($params) . $this->secret);
		return $sign;
	}
}