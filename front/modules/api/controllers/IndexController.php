<?php

namespace app\modules\api\controllers;
use Yii;
use yii\web\Controller;

class IndexController extends Controller 
{
	public $layout = false;
	
	public function actionIndex()
	{
		echo 1;die;
	}
}