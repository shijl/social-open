<?php
namespace app\models;

use Yii;

class Login
{
	public function get_field($field, $value)
	{
		if(empty($field) || empty($value))
			return false;
		
		$sql = "select * from op_api where $field = '$value'";
		
		return Yii::$app->db->createCommand($sql)->queryAll();
	}
	
	public function get_info_fieldid($ids)
	{
		if(empty($ids))
			return false;
		
		$sql = "select * from op_api where id in ($ids)";
		
		return Yii::$app->db->createCommand($sql)->queryAll();
	}
	
	public function check_login($username, $password)
	{
		if(empty($username) || empty($password)) {
			return false;
		}
		
		$sql = "select * from op_admin where username=:username and password=:password";
		$command = Yii::$app->db->createCommand($sql);
		$command->bindParam(':username', $username);
		$command->bindParam(':password', md5($password));
		return $command->queryOne();
	}
}