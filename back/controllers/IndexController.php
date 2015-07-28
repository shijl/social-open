<?php
namespace app\controllers;

use Yii;

class IndexController extends BackController
{	
	public function actionIndex()
	{
		return $this->render('index');
	}
}