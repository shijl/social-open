<?php
namespace app\models\common;

class set_api extends process
{
	
	public function multi(&$process)
	{
		if(!empty($this->_obj)) {
			$this->_obj->multi($process);
		}
		if(!empty($process)) {
			foreach ($process as $pk=>$pv) {
				$id[] = $pv['aid'];
			}
			
			if(!empty($id)) {
				$ids = implode(',', $id);
				$api_info = (new \app\models\Api())->get_info_fieldid($ids);
			}
			
			if(!empty($api_info)) {
				foreach ($api_info as $uk=>$uv) {
					$api_info[$uv['id']] = $uv;
				}
			}
			foreach ($process as $pk=>$pv) {
				$process[$pk]['api_name'] = isset($api_info[$pv['aid']]['api_name']) ? $api_info[$pv['aid']]['api_name'] : '';
			}
		}
	}
}