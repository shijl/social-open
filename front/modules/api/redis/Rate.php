<?php
namespace app\modules\api\redis;

use Yii;

class Rate
{
	private $_pre_key = 'open_platform_';
	public function set_rate($key)
	{
		$key1 = $this->_pre_key . $key;
		$redis = Yii::$app->redis;
		//先查询
		$result = $this->get_rate($key);
		if(empty($result)) {
			return $redis->setex($key1,60,1);
		} else {
			return $redis->incr($key1);
		}
	}
	
	public function get_rate($key)
	{
		$key = $this->_pre_key . $key;
		return Yii::$app->redis->get($key);
	}
	
	public function check_rate($key,$rate)
	{
		$rate_re = $this->get_rate($key);
		if($rate_re >= $rate){
			
			return false;
		} else {
			$this->set_rate($key);

			return true;
		}
	}
	public function stat($key)
	{
		//当前统计分钟
		$minute=date('i')."mins";
		//当前统计月—日-小时
		$date_h=strtotime(date('Y-m-d H:00:01'));
		$redis_key = $key.'_'.$date_h;
		//获取每分钟接口调用次数
		$num = Yii::$app->redis->ZSCORE($redis_key,$minute);
		if(empty($num)){
			$num = 1;
		}else{
			$num+=1;
		}
		//将每分钟接口调用次数加1
		Yii::$app->redis->ZADD($redis_key,$num,$minute);
	}
	public function getstat(){
		$redis_key = 'YmRnaGtucHN2d0JDR0pNTk9RVVZXMDI4_1438326001';
		$result = @Yii::$app->redis->ZREVRANGE($redis_key,0,0,(WITHSCORES));
		var_dump($result);die;
	}
	
}