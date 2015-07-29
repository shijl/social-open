<?php
namespace app\controllers;

use Yii;

class SecretController extends BackController
{
	public function actionList()
	{
		if(isset($_GET['ajax'])) {
			$page = isset($_POST['page']) ? $_POST['page'] : 1;
			$rows = isset($_POST['rows']) ? $_POST['rows'] : 10;
			$secret_obj = new \app\models\Secret();
			$data = $secret_obj->get_list([],$page,$rows);
				
			if(!$data) {
				echo '查询失败';
				exit;
			}
			echo json_encode($data);
		} else {
			return $this->render('list');
		}
	}
}