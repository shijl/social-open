<?php
namespace app\models;

use Yii;

class User
{
	public function get_field($field, $value)
	{
		if(empty($field) || empty($value))
			return false;
		
		$sql = "select * from op_user where $field = '$value'";
		
		return Yii::$app->db->createCommand($sql)->queryAll();
	}
	
	public function get_info_fieldid($ids)
	{
		if(empty($ids))
			return false;
		
		$sql = "select * from op_user where id in ($ids)";
		
		return Yii::$app->db->createCommand($sql)->queryAll();
	}
	
	public function get_list($params=array(), $page=1, $rows=10)
	{
		if(!empty($params) && is_array($params)) {
			foreach ($params as $pk=>$pv)
				$tmp[] = $pk.'='.$pv;
		}
		$query_str = !empty($tmp) ? implode(" and ", $tmp) : '';
	
		$sql = "select count(1) as num from op_user ";
		if(!empty($query_str))
			$sql .= "where ".$query_str;
	
		$db = Yii::$app->db;
		$total = $db->createCommand($sql)->queryOne();
	
		$sql = "select * from op_user ";
	
		if(!empty($query_str))
			$sql .= "where ".$query_str;
	
		$sql .= " order by created_at desc ";
		if($page >=1) {
			$page = ($page-1)*$rows;
			$sql .= " limit $page, $rows";
		}
	
		$re = $db->createCommand($sql)->queryAll();
		$this->_set_process($re);
		
		if(!$re) {
			return false;
		}
		return array('total'=>$total['num'], 'rows'=>$re);
	}
	
	private function _set_process(&$process)
	{
		if(!empty($process) && is_array($process))
		{
			$user_status = Yii::$app->params['user'];
			foreach ($process as $pk=>$pv) {
				$process[$pk]['created_time'] = !empty($pv['created_at']) ? date("Y-m-d",$pv['created_at']) : '';
				$process[$pk]['status_value'] = !empty($pv['status']) ? $user_status[$pv['status']] : '';
			}
		}
	}
	
	public function update_status($id,$status)
	{
		$time = time();
		$sql = "update op_user set status=:status, updated_at=$time where id=:id";
		$db = Yii::$app->db;
		$command = $db->createCommand($sql);
		$command->bindParam(':status', $status, \PDO::PARAM_INT);
		$command->bindParam(':id', $id, \PDO::PARAM_INT);
		return $command->execute();
	}
}