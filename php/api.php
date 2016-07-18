<?php
$appId = YOU_APP_ID;
$appSecret = YOU_APP_SECRET;

$open = new BearOpen();
$open->appId = $appId;
$open->secret = $appSecret;

//获取用户信息
$accessToken = YOUR_APP_ACCESS_TOKEN;
$open->UserInfo($accessToken);

//设置游戏地址
$open->SetGameUrl(YOU_GAME_URL);

//设置支付回调地址
$open->SetNotifyUrl(YOU_NOTIFY_URL);

//设置支付套餐 price 单位 分
$json = '[{"id":1001,"price":100,"name":"10元宝","desc":"10元宝"},{"id":1002,"price":200,"name":"20元宝","desc":"20元宝"}]';
$open->SetProduct($json);

//添加支付白名单ID
$openId = YOUR_OPEN_ID;
$open->AddWhite($openId);

class BearOpen {
	public $appId;
	public $secret;

	public function UserInfo($accessToken) {
		$url = "http://open.ibeargame.com/UserInfo?accessToken=" . $accessToken;
		$this->httpRequest($url, "get", array());
	}

	public function SetProduct($json) {
		$params = array(
			'appId' => $this->appId,
			'data' => $json,
		);

		$sign = $this->makeSign($params);
		$params['sign'] = $sign;
		$url = "http://open.ibeargame.com/SetProduct";
		$this->httpRequest($url, "post", $params);
	}

	public function AddWhite($openId) {
		$params = array(
			'appId' => $this->appId,
			'data' => $openId,
		);

		$sign = $this->makeSign($params);
		$params['sign'] = $sign;
		$url = "http://open.ibeargame.com/AddWhite";
		$this->httpRequest($url, "post", $params);
	}

	public function SetNotifyUrl($url) {
		$params = array(
			'appId' => $this->appId,
			'data' => $url,
		);

		$sign = $this->makeSign($params);
		$params['sign'] = $sign;
		$url = "http://open.ibeargame.com/SetNotifyUrl";
		$this->httpRequest($url, "post", $params);
	}

	public function SetGameUrl($gameUrl) {
		$params = array(
			'appId' => $this->appId,
			'data' => $gameUrl,
		);

		$sign = $this->makeSign($params);
		$params['sign'] = $sign;
		$url = "http://open.ibeargame.com/SetGameUrl";
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
		$sign = md5($this->build_query($params) . $this->secret);
		return $sign;
	}

	private function build_query($params) {
		$arr = array();
		foreach ($params as $key => $value) {
			$arr[] = $key . '=' . $value;
		}
		return implode("&", $arr);
	}

}
