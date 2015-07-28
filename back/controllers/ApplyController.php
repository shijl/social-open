<?php
namespace app\controllers;

use Yii;
use yii\web\Controller;

class ApplyController extends Controller
{
	
	public function actionIndex()
	{
		echo 'apply';
	}
	
	public function actionList()
	{
		if(isset($_GET['ajax'])) {
			$page = isset($_POST['page']) ? $_POST['page'] : 1;
			$rows = isset($_POST['rows']) ? $_POST['rows'] : 10;
			$apply_obj = new \app\models\Api_apply();
			$data = $apply_obj->get_list([],$page,$rows);
			
			if(!$data) {
				echo '查询失败';
				exit;
			}
			echo json_encode($data);
		} else {
			return $this->render('list');
		}
	}
	
	public function actionAgree()
	{
		$id = isset($_GET['id']) ? $_GET['id'] : '';
		$status = isset($_GET['status']) ? $_GET['status'] : '';
		if(empty($id) || empty($status)) {
			echo json_encode(['code'=>10001,'message'=>'参数有误']);
			exit;
		}
		
		$re = (new \app\models\Api_apply())->update_agree($id, $status);
		if($re) {
			// 修改成功生成秘钥
			if($status == 1) {
				$secret_obj = new \app\models\Secret();
				if(!$secret_obj->get_field('apply_id', $id)) {
					$secret_info['apply_id'] = $id;
					$secret_obj->save_secret($secret_info);
				}
			}
			echo json_encode(['code'=>10000,'message'=>'修改成功']);
		} else {
			echo json_encode(['code'=>10002,'message'=>'修改失败']);
		}
	}
}
