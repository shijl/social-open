<?php
namespace app\controllers;

use Yii;
use yii\web\Controller;

class BackController extends Controller
{
	protected $_error_code = [];
	
	public function init()
	{
		
		if(!isset(Yii::$app->session['admin_uid']) || !isset(Yii::$app->session['admin_username'])){
			$this->redirect('/admin.php/login');
		}
	}
	
	protected function _error_code($code)
	{
		return json_encode(array('code'=>$code, 'message'=>$this->_error_code[$code]));
	}
}