<?php
namespace app\module\access\models;

use Yii;

class Other_access
{
	public function get_field($field, $value)
	{
		if(empty($field) || empty($value))
			return false;
	
		$sql = "select * from op_other_access where $field = '$value'";
	
		return Yii::$app->db->createCommand($sql)->queryAll();
	}
	
	public function get_list($params=array(), $page=1, $rows=10)
	{
		if(!empty($params) && is_array($params)) {
			foreach ($params as $pk=>$pv)
				$tmp[] = $pk.'='.$pv;
		}
		$query_str = !empty($tmp) ? implode(" and ", $tmp) : '';
		
		$sql = "select count(1) as num from op_other_access ";
		if(!empty($query_str))
			$sql .= "where ".$query_str;
		
		$db = Yii::$app->db;
		$total = $db->createCommand($sql)->queryOne();
	
		$sql = "select * from op_other_access ";
	
		if(!empty($query_str))
			$sql .= "where ".$query_str;
	
		$sql .= " order by create_at desc ";
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
			$access_status = Yii::$app->modules['access']->params['access_status'];
			foreach ($process as $pk=>$pv) {
				$process[$pk]['created_time'] = !empty($pv['create_at']) ? date("Y-m-d", $pv['create_at']) : '';
				$process[$pk]['access_status'] = !empty($pv['status']) ? $access_status[$pv['status']] : '';
				$process[$pk]['access_ip'] = !empty($pv['access_ip']) ? long2ip($pv['access_ip']) : '';
			}
		}
	}
	
	public function save_other_access($access_info = array())
	{
		$project_name = $access_info['project_name'];
		$leader = $access_info['leader'];
		$qq = $access_info['qq'];
		$phone = $access_info['phone'];
		$access_ip = $access_info['access_ip'];
		$time = time();
		
		$sql = "insert into op_other_access (project_name, leader, qq, phone, access_ip, create_at) 
				values (:project_name, :leader, :qq, :phone, :access_ip, $time)";
		
		$command = Yii::$app->db->createCommand($sql);
		$command -> bindParam(':project_name', $project_name);
		$command -> bindParam(':leader', $leader);
		$command -> bindParam(':qq', $qq);
		$command -> bindParam(':phone', $phone);
		$command -> bindParam(':access_ip', $access_ip);
		
		return $command->execute();
	}
	
	public function update_other_access($access_info = array())
	{
		$id = $access_info['id'];
		$project_name = $access_info['project_name'];
		$leader = $access_info['leader'];
		$qq = $access_info['qq'];
		$phone = $access_info['phone'];
		$access_ip = $access_info['access_ip'];
		
		$time = time();
	
		$sql = "update op_other_access set project_name=:project_name, leader=:leader,
				qq=:qq, phone=:phone, access_ip=:access_ip, update_at=$time where id=:id";
	
		$command = Yii::$app->db->createCommand($sql);
		
		$command -> bindParam(':project_name', $project_name);
		$command -> bindParam(':leader', $leader);
		$command -> bindParam(':qq', $qq);
		$command -> bindParam(':phone', $phone);
		$command -> bindParam(':access_ip', $access_ip);
		$command -> bindParam(':id', $id);
		return $command->execute();
	}
	
	public function update_status($id,$status)
	{
		$time = time();
		$sql = "update op_other_access set status=:status, update_at=$time where id=:id";
		$db = Yii::$app->db;
		$command = $db->createCommand($sql);
		$command->bindParam(':status', $status, \PDO::PARAM_INT);
		$command->bindParam(':id', $id, \PDO::PARAM_INT);
		return $command->execute();
	}
}