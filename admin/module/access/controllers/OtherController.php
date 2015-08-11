<?php
namespace app\module\access\controllers;

use Yii;

class OtherController extends \app\controllers\BackController
{
	protected $_error_code = [
				10001 => '项目名称为空',
				10002 => '负责人为空',
				10003 => 'qq为空',
				10004 => '电话号码为空',
				10005 => '接入IP为空',
				10006 => '项目不存在',
				10007 => '项目已存在',
				10008 => '保存失败',
				10000 => '保存成功',
			];
	
	public function actionIndex()
	{
		if(isset($_GET['ajax'])) {
			$page = isset($_POST['page']) ? $_POST['page'] : 1;
			$rows = isset($_POST['rows']) ? $_POST['rows'] : 10;
			$access_obj = new \app\module\access\models\Other_access();
			$data = $access_obj->get_list([],$page,$rows);
			
			if(!$data) {
				echo '查询失败';
				exit;
			}
			echo json_encode($data);
		} else {
			return $this->render('index');
		}
	}
	
	public function actionStatus()
	{
		$id = isset($_GET['id']) ? $_GET['id'] : '';
		$status = isset($_GET['status']) ? $_GET['status'] : '';
		if(empty($id) || empty($status)) {
			echo json_encode(['code'=>10001,'message'=>'参数有误']);
			exit;
		}
	
		$re = (new \app\module\access\models\Other_access())->update_status($id, $status);
		if($re) {
			echo json_encode(['code'=>10000,'message'=>'修改成功']);
		} else {
			echo json_encode(['code'=>10002,'message'=>'修改失败']);
		}
	}
	
	public function actionView()
	{
		if(isset($_POST["sub"])) {
			if(($valid = $this->_valid_post()) !== true){
				echo $this->_error_code($valid);
				exit;
			}
			
			$post = $_POST;
			$post['access_ip'] = ip2long($post['access_ip']);
			
			$access_obj = new \app\module\access\models\Other_access();
			// 判断是否存在
			if(!empty($post['id'])) {
				if(!($access_obj->get_field('id',$post['id']))) {
					echo $this->_error_code(10006);
					exit;
				}
				$re = $access_obj->update_other_access($post);
			} else {
				if($access_obj->get_field('project_name',$post['project_name'])) {
					echo $this->_error_code(10007);
					exit;
				}
				$re = $access_obj->save_other_access($post);
			}
			
			if(!$re) {
				echo $this->_error_code(10008);
			} else {
				echo $this->_error_code(10000);
			}
		} else {
			$access_info = [];
			if(isset($_GET['id'])) {
				$access_obj = new \app\module\access\models\Other_access();
				$access_info = $access_obj->get_field('id', $_GET['id']);
				$access_info = $access_info[0];
			}
			return $this->render('view', ['access_info'=>$access_info]);
		}
	}
	
	private function _valid_post()
	{
		$id = !empty($_POST['id']) ? $_POST['id'] : '';
		$project_name = !empty($_POST['project_name']) ? $_POST['project_name'] : '';
		$leader = !empty($_POST['leader']) ? $_POST['leader'] : '';
		$qq = !empty($_POST['qq']) ? $_POST['qq'] : '';
		$phone = !empty($_POST['phone']) ? $_POST['phone'] : '';
		$access_ip = !empty($_POST['access_ip']) ? ip2long($_POST['access_ip']) : '';
		if(empty($project_name)) {
			return 10001;
		}
		if(empty($leader)) {
			return 10002;
		}
		if(empty($qq)) {
			return 10003;
		}
		if(empty($phone)) {
			return 10004;
		}
		if(empty($access_ip)) {
			return 10005;
		}
		return true;
	}
}