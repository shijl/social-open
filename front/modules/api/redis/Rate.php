<?php
namespace app\modules\api\redis;

use Yii;

class Rate
{
	private $_pre_key = 'open_platform_';
	public function set_rate($key)
	{
		$key = $this->_pre_key . $key;
		$redis = Yii::$app->redis;
		//先查询
		$result = $this->get_rate($key);
		if(empty($result)) {
			return $redis->setex($key,60,1);
		} else {
			return $redis->incr($key);
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
		if($rate_re > $rate){
			return false;
		} else {
			$this->set_rate($key);
			return true;
		}
	}
}