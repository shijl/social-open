<?php
namespace app\models;

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
	
	public function get_list($params=array(), $page=1, $rows=10)
	{
		if(!empty($params) && is_array($params)) {
			foreach ($params as $pk=>$pv)
				$tmp[] = $pk.'='.$pv;
		}
		$query_str = !empty($tmp) ? implode(" and ", $tmp) : '';
		
		$sql = "select count(1) as num from op_api ";
		if(!empty($query_str))
			$sql .= "where ".$query_str;
		
		$db = Yii::$app->db;
		$total = $db->createCommand($sql)->queryOne();
	
		$sql = "select * from op_api ";
	
		if(!empty($query_str))
			$sql .= "where ".$query_str;
	
		$sql .= " order by created_at desc ";
		if($page >=1) {
			$page = ($page-1)*$rows;
			$sql .= " limit $page, $rows";
		}
	
		$re = $db->createCommand($sql)->queryAll();
		common\multi::get_api($re);
	
		if(!$re) {
			return false;
		}
		return array('total'=>$total['num'], 'rows'=>$re);
	}
	
	public function update_status($id,$status)
	{
		$time = time();
		$sql = "update op_api set status=:status, updated_at=$time where id=:id";
		$db = Yii::$app->db;
		$command = $db->createCommand($sql);
		$command->bindParam(':status', $status, \PDO::PARAM_INT);
		$command->bindParam(':id', $id, \PDO::PARAM_INT);
		return $command->execute();
	}
	
	public function save_api($api_info)
	{
		if(empty($api_info))
			return false;
		$api_name = $api_info['api_name'];
		$api_url = $api_info['api_url'];
		$type = $api_info['type'];
		$time = time();
	
		$sql = "insert into op_api (api_name, api_url, type, created_at)
		values (:api_name, :api_url, :type, $time)";
		$command = Yii::$app->db->createCommand($sql);
		$command->bindParam(':api_name', $api_name, \PDO::PARAM_STR);
		$command->bindParam(':api_url', $api_url, \PDO::PARAM_STR);
		$command->bindParam(':type', $type, \PDO::PARAM_INT);
	
		return $command->execute();
	}
}