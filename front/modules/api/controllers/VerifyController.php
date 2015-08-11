<?php

namespace app\modules\api\controllers;
use Yii;
use yii\web\Controller;

class VerifyController extends Controller 
{
	public $layout = false;
	public function actionEncryption(){
		$user_id = 20;
		$time=time();
		$string = $this->make_password();
		$key = sha1(md5($string));
		Yii::$app->redis->setex('keys',60,$key);
		$sign = base64_encode($user_id."_".$time."_".$key);
		$http_query = [
			'uid' => $user_id,
			'time' => $time,
			'sign' => $sign,
		];
		$url = 'http://test.social-open.com/api/verify/decrypt?'.http_build_query($http_query);
		echo '
				<html>
				<body style="margin:0 0;">
				<div style="width:100%; height:100%; overflow:hidden;">
				<iframe width="100%" scrolling="auto" height="100%" frameborder="0" name="mainFrame" src="'.$url.'"> </iframe>
				</div>
				</body>
				</html>
			';
		
	}
	public function actionDecrypt(){
		$query = Yii::$app->request->queryParams;
		if(empty($query)){
			echo json_encode(['error' => ['code' => '100001', 'message' => '禁止访问']]);
		}
		$key = Yii::$app->redis->get('keys');
		if(empty($key)){
			echo json_encode(['error' => ['code' => '100001', 'message' => '禁止访问']]);
		}
		$sign = base64_encode($query['uid']."_".$query['time']."_".$key);
		if($sign==$query['sign']){
			echo json_encode(['error' => ['code' => '200001', 'message' => '允许访问']]);
		}else{
			echo json_encode(['error' => ['code' => '100001', 'message' => '禁止访问']]);
		}
	}
	function make_password( $length = 8 ){
		// 密码字符集，可任意添加你需要的字符
		$chars = array('a', 'b', 'c', 'd', 'e', 'f', 'g', 'h',
				'i', 'j', 'k', 'l','m', 'n', 'o', 'p', 'q', 'r', 's',
				't', 'u', 'v', 'w', 'x', 'y','z', 'A', 'B', 'C', 'D',
				'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L','M', 'N', 'O',
				'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y','Z',
				'0', '1', '2', '3', '4', '5', '6', '7', '8', '9', '_');
	
		// 在 $chars 中随机取 $length 个数组元素键名
		$keys = array_rand($chars, $length);
	
		$password = '';
		for($i = 0; $i < $length; $i++)
		{
		// 将 $length 个数组元素连接成字符串
		$password .= $chars[$keys[$i]];
		}
	
		return $password;
	}
}