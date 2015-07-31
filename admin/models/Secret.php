<?php
namespace app\models;

use Yii;

class Secret
{
	public function get_field($field, $value)
	{
		if(empty($field) || empty($value))
			return false;
	
		$sql = "select * from op_key where $field = '$value'";
	
		return Yii::$app->db->createCommand($sql)->queryAll();
	}
	
	public function get_info_fieldid($ids)
	{
		if(empty($ids))
			return false;
	
		$sql = "select * from op_key where id in ($ids)";
	
		return Yii::$app->db->createCommand($sql)->queryAll();
	}
	
	public function get_info_applyid($ids)
	{
		if(empty($ids))
			return false;
	
		$sql = "select * from op_key where apply_id in ($ids)";
	
		return Yii::$app->db->createCommand($sql)->queryAll();
	}
	
	public function get_list($params=array(), $page=1, $rows=10)
	{
		if(!empty($params) && is_array($params)) {
			foreach ($params as $pk=>$pv)
				$tmp[] = $pk.'='.$pv;
		}
		$query_str = !empty($tmp) ? implode(" and ", $tmp) : '';
		
		$sql = "select count(1) as num from op_key";
		$db = Yii::$app->db;
		if(!empty($query_str))
			$sql .= "where ".$query_str;
		$total = $db->createCommand($sql)->queryOne();
	
		$sql = "select * from op_key ";
		if(!empty($query_str))
			$sql .= "where ".$query_str;
		$sql .= " order by created_at desc ";
		if($page >=1) {
			$page = ($page-1)*$rows;
			$sql .= " limit $page, $rows";
		}
	
		$re = $db->createCommand($sql)->queryAll();
		$apply_id = common\Assist::get_fields($re, 'apply_id');
		$apply_tmp = array();
		if(!empty($apply_id)) {
			$apply_info = (new Api_apply())->get_info_fieldid($apply_id);
			if(!empty($apply_info)) {
				foreach ($apply_info as $ak=>$av) {
					$apply_tmp[$av['id']] = $av;
				}
			}
		}
		
		foreach($re as $rk=>$rv) {
			$re[$rk]['uid'] = isset($apply_tmp[$rv['apply_id']]['uid']) ? $apply_tmp[$rv['apply_id']]['uid'] : '';
			$re[$rk]['aid'] = isset($apply_tmp[$rv['apply_id']]['aid']) ? $apply_tmp[$rv['apply_id']]['aid'] : '';
			$re[$rk]['rate'] = isset($apply_tmp[$rv['apply_id']]['rate']) ? $apply_tmp[$rv['apply_id']]['rate'] : '';
			$re[$rk]['is_agree'] = isset($apply_tmp[$rv['apply_id']]['is_agree']) ? $apply_tmp[$rv['apply_id']]['is_agree'] : '';
				
		}
		
		common\multi::get_multi($re);
	
		if(!$re) {
			return false;
		}
		return array('total'=>$total['num'], 'rows'=>$re);
	}
	
	public function save_secret($secret_info)
	{
		if(empty($secret_info))
			return false;
		$apply_id = $secret_info['apply_id'];
		$key = libs\Tools::get_secret();
		$time = time();
	
		$sql = "insert into op_key (apply_id, secret_key, created_at)
				values (:apply_id, '$key', '$time')";
		$command = Yii::$app->db->createCommand($sql);
		$command->bindParam(':apply_id', $apply_id, \PDO::PARAM_INT);
	
		return $command->execute();
	}
}