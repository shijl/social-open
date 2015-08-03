<?php
namespace app\modules\api\models;

use Yii;

class User
{
	public function get_field($field, $value)
	{
		if(empty($field) || empty($value))
			return false;
	
		$sql = "select * from op_user where $field = '$value'";
	
		return Yii::$app->db->createCommand($sql)->queryOne();
	}
}