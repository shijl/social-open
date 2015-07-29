<?php
namespace app\models\common;

use Yii;
class set_api_info extends process
{
	
	public function multi(&$process)
	{
		if(!empty($this->_obj)) {
			$this->_obj->multi($process);
		}
		$api = Yii::$app->params['api'];
		if(!empty($process)) {
			foreach ($process as $pk=>$pv) {
				$process[$pk]['api_type'] = isset($api['type'][$pv['type']]) ? $api['type'][$pv['type']] : '';
				$process[$pk]['api_status'] = isset($api['status'][$pv['status']]) ? $api['status'][$pv['status']] : '';
				$process[$pk]['created_time'] = !empty($pv['created_at']) ? date("Y-m-d H:i:s", $pv['created_at']) : '';
				$process[$pk]['updated_time'] = !empty($pv['updated_at']) ? date("Y-m-d H:i:s", $pv['updated_at']) : '';
			}
		}
	}
}