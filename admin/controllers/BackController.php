<?php
namespace app\controllers;

use Yii;
use yii\web\Controller;

class BackController extends Controller
{
	public function init()
	{
		if(!isset(Yii::$app->session['uid']) || !isset(Yii::$app->session['username'])) {
			header("Location:/admin.php/login");
		}
	}
}