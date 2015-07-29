<?php
namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\Apply;
use app\models\User;

class ApplyController extends BaseController
{	
	public $layout = 'main';
	public $enableCsrfValidation = false;
	public function actionIndex(){
		$user_id = Yii::$app->getUser()->getIdentity()->id;
		$sql = "select apply.id,apply.rate,apply.is_agree,apply.created_at,apply.agree_time,api.api_name,api.api_url,api.type from op_api_apply as apply left join op_api as api on apply.aid = api.id where uid = '".$user_id."' order by apply.created_at desc";
		$query = Apply::findBySql($sql)->all();
		$output=[];
		foreach($query as $model){
			$item = [
			'id' =>$model->id,
			'api_name' =>$model->api_name,
			'api_url' =>$model->api_url,
			'api_type' =>yii::$app->params['api_type'][$model->type],
			'rate' =>yii::$app->params['rate'][$model->rate],
			'is_agree' =>(!empty($model->is_agree)?(($model->is_agree=='1')?"通过":"未通过"):'待审核'),
			'created_at' =>$model->created_at?date("Y-m-d H:i:s",$model->created_at):'',
			'agree_time' =>$model->agree_time?date("Y-m-d H:i:s",$model->agree_time):'',
			];
			$output[]=$item;
		}
		return $this->render('index',['list'=>$output]);
	}
	public function actionCreate(){
		$api_id = Yii::$app->getRequest()->post('apiid');
		$rate = Yii::$app->getRequest()->post('rate');
		$user_id = Yii::$app->getUser()->getIdentity()->id;
		$model = Apply::findOne(['aid' => $api_id,'uid'=>$user_id]);	
		if($model) {
			echo json_encode(array('code'=>101,'message' =>'不能重复申请'));die;
		}
		$model = new Apply();
		$model->uid = $user_id;
		$model->aid = $api_id;
		$model->rate = $rate;
		$model->created_at = time();
		if(!$model->save())
		{
			echo json_encode(array('code'=>102,'message' =>'申请失败'));die;
		}
		echo json_encode(array('success'=>true));die;
	}
	public function actionGetKey(){
		$id = Yii::$app->getRequest()->post('id');
		$sql = "select secret_key from op_key where apply_id = $id";
		$result = Yii::$app->db->createCommand($sql)->queryOne();
		echo json_encode(array('success'=>true,'key'=>$result['secret_key']));die;
		
	}
	
}