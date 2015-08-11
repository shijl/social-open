<?php

namespace app\modules\verify\controllers;
use Yii;
use yii\web\Controller;

class VerifyController extends Controller 
{
	public $layout = false;
	private $key = "egIJKLijkVZmnostuvxzABCEG3PQR019";
	public function actionDecrypt(){
		$query = Yii::$app->request->queryParams;
		$time = time();
		if(empty($query)){
			echo json_encode(['error' => ['code' => '100001', 'message' => '禁止访问']]);die;
		}
		if(empty($query['time'])||empty($query['timeout'])){
			echo json_encode(['error' => ['code' => '100002', 'message' => '参数错误']]);die;
		}
		$timeout = $query['time']+$query['timeout'];
		if($time>$timeout){
			echo json_encode(['error' => ['code' => '100003', 'message' => '请求过期']]);die;
		}
		$str = $query['time'].$query['timeout'].$this->key;
		$sign =  hash_hmac( 'sha1', $str, $this->key);
		if($sign==$query['sign']){
			echo json_encode(['success' => ['code' => '200001', 'message' => '允许访问']]);
		}else{
			echo json_encode(['error' => ['code' => '100004', 'message' => 'sign无效']]);
		}
	}
}