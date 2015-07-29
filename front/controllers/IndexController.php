<?php
namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\User;

class IndexController extends BaseController
{	
	public $layout = 'main';
	public function actionIndex()
	{
		$user = Yii::$app->getUser()->getIdentity();
		if($user){
			$this->redirect('/apply');
		}
		return $this->render('index');
	}
}