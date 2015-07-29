<?php
namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\Apply;
use app\models\Api;

class ApiController extends BaseController
{	
	public $layout = 'main';
	public function actionIndex(){
		$condition=[];
		$condition['status']=1;
		$query = Api::find()->where($condition);
		$query->orderBy('created_at DESC');
		$models = $query->all();
		$output=[];		
		foreach($models as $model){
			$item = [
			'id' =>$model->id,
			'api_name' =>$model->api_name,
			'api_url' =>$model->api_url,
			'api_type' =>$model->type,
			'created_at' =>$model->created_at?date("Y-m-d H:i:s",$model->created_at):'',
			];
			$output[]=$item;
		}
		return $this->render('index',['list'=>$output]);
	}
}