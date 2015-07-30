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
		if($apply_re['is_agree'] == '0') {
			echo json_encode(array('code'=>10004,'data'=>'申请状态待审核'));
			exit;
		} elseif($apply_re['is_agree'] == '2') {
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
		echo $this->request($api_result['api_url'],$_GET,'GET');
	}
	public function request($url,$params=array(),$method= 'GET')
	{
		if(!function_exists('curl_init')) exit('Need to open the curl extension');
		$method = strtoupper($method);
		$ci = curl_init();
		curl_setopt($ci, CURLOPT_CONNECTTIMEOUT, 3);	//在发起连接前等待的时间
		curl_setopt($ci, CURLOPT_TIMEOUT, 3);			//等待响应的时间
		curl_setopt($ci, CURLOPT_RETURNTRANSFER, true);	//获取结果作为字符串返回
		curl_setopt($ci, CURLOPT_SSL_VERIFYPEER, false);//支持SSL加密
		curl_setopt($ci, CURLOPT_HEADER, false);		//获取返回头信息
		switch ($method)
		{
			case 'POST':
				curl_setopt($ci, CURLOPT_POST, TRUE);
				if (!empty($params))
				{
					curl_setopt($ci, CURLOPT_POSTFIELDS, http_build_query($params));
				}
				break;
			case 'GET':
				if (!empty($params))
				{
					$url = $url . (strpos($url, '?') ? '&' : '?')
					. (is_array($params) ? http_build_query($params) : $params);
				}
				break;
		}
		curl_setopt($ci, CURLOPT_URL, $url);
		$response = curl_exec($ci);
		curl_close ($ci);
		return $response;
	}
}