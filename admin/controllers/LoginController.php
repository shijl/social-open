<?php
namespace app\controllers;

use Yii;
use yii\web\Controller;

class LoginController extends Controller
{
	public function actionIndex()
	{
		return $this->render('index');
	}
	
	public function actionLogin()
	{
		if(isset($_POST["sub"])) {
			$log_name = !empty($_POST['username']) ? $_POST['username'] : '';
			$log_pass = !empty($_POST['password']) ? $_POST['password'] : '';
			if(empty($log_name)) {
				echo json_encode(array('code'=>10001, 'message'=>'用户名为空'));
				exit;
			}
			if(empty($log_pass)) {
				echo json_encode(array('code'=>10002, 'message'=>'密码为空'));
				exit;
			}
			
			// 判断是否存在
			$login_obj = new \app\models\Login();
			$check_result = $login_obj->check_login($log_name, $log_pass);
			if(!$check_result) {
				echo json_encode(array('code'=>10003, 'message'=>'用户不存在'));
				exit;
			}
			if($check_result['status'] == 2) {
				echo json_encode(array('code'=>10004, 'message'=>'用户已锁定，请联系管理员'));
				exit;
			}
			Yii::$app->session['admin_uid'] = $check_result['id'];
			Yii::$app->session['admin_username'] = $check_result['username'];
			echo json_encode(array('code'=>10000, 'message'=>'登陆成功'));
		} else {
			echo json_encode(array('code'=>10009, 'message'=>'非法提交')); 
		}
	}
	
	public function actionLogout()
	{
		unset(Yii::$app->session['admin_uid']);
		unset(Yii::$app->session['admin_username']);
		header("Location:/admin.php/login");
	}
}