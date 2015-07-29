<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\User;
use app\models\UserForm;


class UserController extends BaseController
{
	public $enableCsrfValidation = false;
	public $layout = false;

	/**
	 * 创建用户
	 * @return Ambigous <string, string>
	 */
	public function actionCreate()
	{
		$modelf = new UserForm();
		$modelf->scenario = 'create';
		if(!$modelf->load(Yii::$app->request->post(),'') || !$modelf->validate()) {
			return $this->renderContent(json_encode(array('code'=>102,'message' =>'验证失败')));
		}
		
		if($modelf->existUsername()) {
			return $this->renderContent(json_encode(array('code'=>107,'message' =>'用户名已存在')));
		}
		$model = new User();
		$model->password = $modelf->password;
		$model->username = $modelf->username;
		$model->project = $modelf->project;
		$model->department = $modelf->department;
		$model->qq = $modelf->qq;
		if(!$model->save())
		{
			return $this->renderContent(json_encode(array('code'=>201,'message' =>'创建失败')));
		}
		return $this->renderContent(json_encode(array('success'=>true)));
	}
	/**
	 * 返回内置的Action类
	 * @see \yii\base\Controller::actions()
	 */
	public function actions()
	{
		return [
			'error' => [
				'class' => 'yii\web\ErrorAction',
			],
			'captcha' => [
				'class' => 'yii\captcha\CaptchaAction',
				'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
			],
		];
	}
	
	/**
	 * 用户登录系统
	 * @return Ambigous <\yii\web\Response, \yii\web\static, \yii\web\Response>|Ambigous <string, string>
	 */
	public function actionLogin()
	{
		$modelf = new UserForm();
		$modelf->scenario = 'login';
		if ($modelf->load(Yii::$app->request->post(), '') && $modelf->validate())
		{
			Yii::$app->getUser()->login($modelf->getUser(), $modelf->rememberMe ? 3600 * 24 * 30 : 0);
			return $this->renderContent(json_encode(array('success'=>true)));
		}
		else
		{
			return $this->renderContent(json_encode(array('code'=>102,'message' =>'用户名或密码输入有误')));
		}
	}
	
	/**
	 * 用户退出系统
	 * @return Ambigous <\yii\web\Response,\yii\web\static, \yii\web\Response>
	 */
	public function actionLogout()
	{
		Yii::$app->getUser()->logout();
		$this->redirect('/apply');
	}
}