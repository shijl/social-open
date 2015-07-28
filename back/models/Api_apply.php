<?php
namespace app\models;

use Yii;

class Api_apply
{
	public function get_list($params=array(), $page=1, $rows=10)
	{
		$sql = "select count(1) as num from op_api_apply";
		$db = Yii::$app->db;
		$total = $db->createCommand($sql)->queryOne();
	
		$sql = "select * from op_api_apply ";
		
		if(!empty($params) && is_array($params)) {
			foreach ($params as $pk=>$pv) 
				$tmp[] = $pk.'='.$pv;
		}
		$query_str = !empty($tmp) ? implode(" and ", $tmp) : '';
		
		if(!empty($query_str))
			$sql .= "where ".$query_str;
	
		if($page >=1) {
			$page = ($page-1)*$rows;
			$sql .= " limit $page, $rows";
		}
	
		$re = $db->createCommand($sql)->queryAll();
		common\multi::get_multi($re);
	
		if(!$re) {
			return false;
		}
		return array('total'=>$total['num'], 'rows'=>$re);
	}
	
	public function update_agree($id,$status)
	{
		$sql = "update op_api_apply set is_agree=:is_agree where id=:id";
		$db = Yii::$app->db;
		$command = $db->createCommand($sql);
		$command->bindParam(':is_agree', $status, \PDO::PARAM_INT);
		$command->bindParam(':id', $id, \PDO::PARAM_INT);
		return $command->execute();
	}
}