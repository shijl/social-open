<?php
namespace app\modules\api\models;

use Yii;

class Secret
{
	public function get_field($field, $value)
	{
		if(empty($field) || empty($value))
			return false;
	
		$sql = "select * from op_key where $field = '$value'";
	
		return Yii::$app->db->createCommand($sql)->queryOne();
	}
	
	public function get_info_fieldid($ids)
	{
		if(empty($ids))
			return false;
	
		$sql = "select * from op_key where id in ($ids)";
	
		return Yii::$app->db->createCommand($sql)->queryAll();
	}
}