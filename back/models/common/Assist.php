<?php
namespace app\models\common;

class Assist
{
	public static function get_fields($process, $field)
	{
		if(empty($process) || !is_array($process)){
			return false;
		}
		foreach ($process as $pk=>$pv) {
			$id[] = $pv[$field];
		}
		
		if(!empty($id)) {
			return implode(',', $id);
		}
		return false;
	}
}