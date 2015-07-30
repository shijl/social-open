<?php
namespace app\modules\api\models;

use Yii;

class Api
{
	public function get_field($field, $value)
	{
		if(empty($field) || empty($value))
			return false;
		
		$sql = "select * from op_api 	where $field = '$value'";
		
		return Yii::$app->db->createCommand($sql)->queryAll();
	}
	
	public function get_info_fieldid($ids)
	{
		if(empty($ids))
			return false;
		
		$sql = "select * from op_api where id in ($ids)";
		
		return Yii::$app->db->createCommand($sql)->queryAll();
	}
}