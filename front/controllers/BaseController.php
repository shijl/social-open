<?php
namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;

class BaseController extends Controller{
	public function behaviors(){
		return [
            'access' => [
				'class' => AccessControl::className(),
				'rules' => [
					[
						'allow' => true,
						'controllers' => ['index','user'],
						'actions' => ['index','create','login'],
						'roles' => ['?'],
					],

				],
			],
        ];
	}
}