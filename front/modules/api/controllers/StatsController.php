<?php

namespace app\modules\api\controllers;
use Yii;
use yii\web\Controller;
use app\modules\api\models\Stats;

class StatsController extends Controller 
{
	public $layout = false;
	public function actionIndex(){
		//$redis_key = 'YmRnaGtucHN2d0JDR0pNTk9RVVZXMDI4_1438326001';
		//$result = @Yii::$app->redis->ZREVRANGE($redis_key,0,0,(WITHSCORES));
		$hour = isset($_GET['hour']) ? $_GET['hour'] : '';
		if(empty($hour)){
			return false;
		}
		$secret = new \app\modules\api\models\Secret();
		$keys = $secret->get_keys_info();
		$time = strtotime(date("Y-m-d")." ".$hour.date(":00:01"));
		foreach($keys as $k => $v){
			$redis_key=$v['secret_key']."_".$time;
			$result = @Yii::$app->redis->ZREVRANGE($redis_key,0,0,(WITHSCORES));
			if(!empty($result)){
				$model = new Stats();
				$model->secret_key = $v['secret_key'];
				$model->access_num = !empty($result)?$result[1]:0;
				$model->stat_time = (int)$time-1;
				$model->create_time = time();
				$model->save();
			}
		}
	}
}