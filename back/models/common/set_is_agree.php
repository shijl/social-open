<?php
namespace app\models\common;

use Yii;
class set_is_agree
{
	public function multi(&$process)
	{
		$agree_arr = Yii::$app->params['api_apply_agree'];
		if(!empty($this->_obj)) {
			$this->_obj->multi($process);
		}
		if(!empty($process)) {
			foreach ($process as $pk=>$pv) {
				$process[$pk]['agree_status'] = $agree_arr[$pv['is_agree']];
			}
		}
	}
}