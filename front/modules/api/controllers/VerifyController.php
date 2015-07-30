<?php

namespace app\modules\api\controllers;
use Yii;
use yii\web\Controller;

class VerifyController extends Controller 
{
	public $layout = false;
	
	public function actionGetData(){
		echo json_encode(array('code'=>10007,'data'=>$_GET));
	}
}