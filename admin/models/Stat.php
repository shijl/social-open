<?php
namespace app\models;

use Yii;

class Stat
{
	public function get_field($field, $value)
	{
		if(empty($field) || empty($value))
			return false;
	
		$sql = "select * from op_api_stat where $field = '$value'";
	
		return Yii::$app->db->createCommand($sql)->queryAll();
	}
	
	public function get_info_fieldid($ids)
	{
		if(empty($ids))
			return false;
	
		$sql = "select * from op_api_stat where id in ($ids)";
	
		return Yii::$app->db->createCommand($sql)->queryAll();
	}
	
	public function get_most_num($field, $value)
	{
		if(empty($field) || empty($value))
			return false;
	
		$sql = "select access_num from op_api_stat where $field = '$value' order by access_num desc limit 1";
	
		$re = Yii::$app->db->createCommand($sql)->queryOne();
		if($re) {
			return $re['access_num'];
		}
		return 0;
		
	}
}