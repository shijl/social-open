<?php

namespace app\modules\api\controllers;
use Yii;
use yii\web\Controller;
use app\modules\api\models\Verify;

class IndexController extends Controller 
{
	public $layout = false;
	
	public function actionIndex()
	{
		$key = isset($_GET['key']) ? $_GET['key'] : '';
		$verify = new Verify($key);
		echo $this->request($verify->api_url,$_GET,'GET');
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
		curl_setopt($ci, CURLOPT_HEADER, false);//获取返回头信息
		switch ($method){
			case 'POST':
				curl_setopt($ci, CURLOPT_POST, TRUE);
				if(!empty($params)){
					curl_setopt($ci, CURLOPT_POSTFIELDS, http_build_query($params));
				}
				break;
			case 'GET':
				if(!empty($params)){
					$url = $url . (strpos($url, '?') ? '&' : '?')
					. (is_array($params) ? http_build_query($params) : $params);
				}
				break;
		}
		curl_setopt($ci,CURLOPT_URL,$url);
		$response = curl_exec($ci);
		curl_close ($ci);
		return $response;
	}
}