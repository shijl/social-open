<?php
namespace app\controllers;

use Yii;
use yii\web\Controller;

class IndexController extends Controller
{	
	public function actionIndex()
	{
		$redis = Yii::$app->redis;
		$redis->set('a','b');
		
		echo $redis->get('a');
	}
	
	
}