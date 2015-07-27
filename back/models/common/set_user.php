<?php
namespace app\models\common;

class set_user extends process
{
	
	public function multi(&$process)
	{
		if(!empty($this->_obj)) {
			$this->_obj->multi($process);
		}
		if(!empty($process)) {
			foreach ($process as $pk=>$pv) {
				$id[] = $pv['uid'];
			}
			
			if(!empty($id)) {
				$ids = implode(',', $id);
				$user_info = (new \app\models\User())->get_info_fieldid($ids);
			}
			
			if(!empty($user_info)) {
				foreach ($user_info as $uk=>$uv) {
					$user_info[$uv['id']] = $uv;
				}
			}
			foreach ($process as $pk=>$pv) {
				$process[$pk]['username'] = isset($user_info[$pv['uid']]['username']) ? $user_info[$pv['uid']]['username'] : '';
				$process[$pk]['department'] = isset($user_info[$pv['uid']]['department']) ? $user_info[$pv['uid']]['department'] : '';
			}
		}
	}
}