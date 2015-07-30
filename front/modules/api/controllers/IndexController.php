<?php

namespace app\modules\api\controllers;
use Yii;
use yii\web\Controller;

class IndexController extends Controller 
{
	public $layout = false;
	
	public function actionIndex()
	{
		$key = isset($_GET['key']) ? $_GET['key'] : '';
		if(empty($key)) {
			echo json_encode(array('code'=>10001,'data'=>'秘钥为空'));
			exit;
		}
		$secret_obj = new \app\modules\api\models\Secret();
		$result = $secret_obj->get_field('secret_key', $key);
		if(!$result) {
			echo json_encode(array('code'=>10002,'data'=>'秘钥不存在'));
			exit;
		}
		// 查找apply_id
		$result = array_shift($result);
		$apply_id = $result['apply_id'];
		$apply_obj = new \app\modules\api\models\Api_apply();
		$apply_re = $apply_obj->get_field('id', $apply_id);
		if(!$apply_re) {
			echo json_encode(array('code'=>10003,'data'=>'申请记录不存在'));
			exit;
		}
		$apply_re = array_shift($result);
		if($apply_re['is_agree'] == 0) {
			echo json_encode(array('code'=>10004,'data'=>'申请状态待审核'));
			exit;
		} elseif($apply_re['is_agree'] == 2) {
			echo json_encode(array('code'=>10005,'data'=>'申请状态未通过'));
			exit;
		}
		// 判断接口是否可用
		$api_obj = new \app\modules\api\models\Api();
		$api_id = $apply_re['aid'];
		$api_result = $api_obj->get_field('id', $api_id);
		if(!$api_result) {
			echo json_encode(array('code'=>10006,'data'=>'接口不存在'));
			exit;
		}
		$api_result = array_shift($result);
		if($api_result['status'] == 2) {
			echo json_encode(array('code'=>10007,'data'=>'接口已停用'));
			exit;
		}
		// 判断速率
		$rate_obj = new \app\modules\api\redis\Rate();
		$rate = Yii::$app->params['rate_value'][$apply_re['rate']];
		if(!($rate_obj->check_rate($key, $rate))){
			echo json_encode(array('code'=>10008,'data'=>'接口请求次数过多'));
			exit;
		}
	}
}