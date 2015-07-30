<?php

namespace app\modules\api\controllers;
use Yii;
use yii\web\Controller;

class VerifyController extends Controller 
{
	public $layout = false;
	
	public function actionGetData(){
		$data = !empty($_GET)?$_GET:'';
		if(empty($data)){
			echo json_encode(array('code'=>'10000', 'meassage'=>'Invalid request'));die;
		}
		$key = isset($_GET['key'])?$_GET['key']:'';
		if(empty($key)){
			echo json_encode(array('code'=>'10001', 'meassage'=>'Invalid key'));die;
		}else{
			echo $key;
		}
		
	}
}