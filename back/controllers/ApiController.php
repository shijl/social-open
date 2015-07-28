<?php
namespace app\controllers;

use Yii;
use yii\web\Controller;

class ApiController extends Controller
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
			echo json_encode($data);
		} else {
			$type = Yii::$app->params['api']['type'];
			return $this->render('list',['type'=>$type]);
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
	
		$re = (new \app\models\Api())->update_status($id, $status);
		if($re) {
			// 修改成功生成秘钥
			echo json_encode(['code'=>10000,'message'=>'修改成功']);
		} else {
			echo json_encode(['code'=>10002,'message'=>'修改失败']);
		}
	}
	
	public function actionAdd()
	{
		if(isset($_POST["sub"])) {
			$api_name = !empty($_POST['api_name']) ? $_POST['api_name'] : '';
			$api_url = !empty($_POST['api_url']) ? $_POST['api_url'] : '';
			$type = !empty($_POST['type']) ? $_POST['type'] : '';
			if(empty($api_name)) {
				echo json_encode(array('code'=>10001, 'message'=>'接口名称为空'));
				exit;
			}
			if(empty($api_url)) {
				echo json_encode(array('code'=>10002, 'message'=>'接口地址为空'));
				exit;
			}
			if(empty($type)) {
				echo json_encode(array('code'=>10003, 'message'=>'接口类型为空'));
				exit;
			}
			// 判断是否存在
			
			$api_obj = new \app\models\Api();
			if($api_obj->get_field('api_name',$api_name)) {
				echo json_encode(array('code'=>10005, 'message'=>'接口已存在'));
				exit;
			}
			$api_info = [
				'api_name'=>$api_name,
				'api_url'=>$api_url,
				'type'=>$type
			];
			$re = $api_obj->save_api($api_info);
			if(!$re) {
				echo json_encode(array('code'=>10006, 'message'=>'添加失败'));
			} else {
				echo json_encode(array('code'=>10000, 'message'=>'添加成功'));
			}
		} else {
			echo json_encode(array('code'=>10009, 'message'=>'非法提交')); 
		}
	}
}
