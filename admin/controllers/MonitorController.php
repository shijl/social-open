<?php
namespace app\controllers;

use Yii;

class MonitorController extends BackController
{
	public function actionList()
	{
		if(isset($_GET['ajax'])) {
			$page = isset($_POST['page']) ? $_POST['page'] : 1;
			$rows = isset($_POST['rows']) ? $_POST['rows'] : 10;
			$api_obj = new \app\models\Api();
			$data = $api_obj->get_list([],$page,$rows);
			
			if(!$data) {
				echo '查询失败';
				exit;
			}
			// 查询最多的次数
			$apply_info = $this->get_secret_key($data['rows']);
			foreach ($data['rows'] as $dk=>$dv) {
				$all_num = 0;
				if(!empty($apply_info)) {
					foreach ($apply_info as $ak=>$av) {
						if($av['aid'] == $dv['id']) {
							$all_num = $all_num+$av['access_num'];
						}
					}
					
				}
				$data['rows'][$dk]['all_num'] = $all_num;
			}
			
			echo json_encode($data);
		} else {
			return $this->render('list');
		}
	}
	
	public function actionItem()
	{
		$id = isset($_GET['id']) ? $_GET['id'] : '';
		$page = isset($_POST['page']) ? $_POST['page'] : 1;
		$rows = isset($_POST['rows']) ? $_POST['rows'] : 10;
		
		if(empty($id)) {
			echo '参数有误';exit;
		}
		$params = ['aid'=>$id, 'is_agree'=>1];
		$apply_obj = new \app\models\Api_apply();
		$apply_info = $apply_obj->get_list($params, $page, $rows);
		$apply_info_rows = $this->process_allly_info($apply_info['rows']);
		
		\app\models\common\multi::get_multi($apply_info_rows);
		// 根据接口id查询申请记录
		
		$re['total'] = $apply_info['total'];
		$re['rows'] = $apply_info_rows;
		echo json_encode($re);
		
	}
	
	// 接口id查询接口申请情况-》查询secretkey
	public function get_secret_key($re)
	{
		if(empty($re) || !is_array($re)) {
			return $re;
		}
		
		$ids = \app\models\common\Assist::get_fields($re, 'id');
		// 查询申请记录
		$apply_obj = new \app\models\Api_apply();
		$apply_info = $apply_obj->get_info_aid($ids);
		// 查询申请记录的key
		if(empty($apply_info)) {
			return $re;
		}
		$apply_info = $this->process_allly_info($apply_info);
		if($apply_info) {
			return $apply_info;
		}
		return $re;
	}
	
	public function process_allly_info($apply_info)
	{
		$aids = \app\models\common\Assist::get_fields($apply_info, 'id');
		$secret_obj = new \app\models\Secret();
		$secret_info = $secret_obj->get_info_applyid($aids);
		if(empty($secret_info)) {
			return false;
		}
		
		$stat_obj = new \app\models\Stat();
		// 查询每个secret_key的历史访问峰值
		foreach ($secret_info as $sk=>$sv) {
			// 查询一个最多的值
			$num = $stat_obj->get_most_num('secret_key', $sv['secret_key']);
			$sv['access_num'] = $num;
			$secret_tmp[$sv['apply_id']] = $sv;
		}
		foreach ($apply_info as $ak=>$av) {
			$apply_info[$ak]['secret_key'] = $secret_tmp[$av['id']]['secret_key'];
			$apply_info[$ak]['access_num'] = $secret_tmp[$av['id']]['access_num'];
		}
		
		return $apply_info;
	}
}