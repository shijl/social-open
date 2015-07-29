<?php
namespace app\controllers;

use Yii;
use yii\web\Controller;

class BackController extends Controller
{
	public function init()
	{
		if(!isset(Yii::$app->session['admin_uid']) || !isset(Yii::$app->session['admin_username'])) {
			header("Location:/admin.php/login");
		}
	}
}