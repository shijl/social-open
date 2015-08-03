<?php
namespace app\modules\api\models;

use Yii;
use app\modules\api\redis\Rate;
class Verify
{
	private $api;
	private $rate;
	private $apply;
	private $secret;
	private $error;
	public $apply_id=null;
	public $api_id=null;
	public $user_id =null;
	public $api_url=null;
	public $api_rate=null;
	public function __construct($key){
		$this->api= new Api();
		$this->user= new User();
		$this->apply= new Api_apply();
		$this->rate= new Rate();
		$this->secret= new Secret();
		$this->keyVerify($key);
		$this->apiStat($key);
		$this->applyVerify();
		$this->userVerify();
		$this->apiVerify();
		$this->rateVerify($key);
		
	}
	/**
	 * 密钥验证
	 * @param unknown $key
	 */
	public function keyVerify($key){
		if(empty($key)){
			$this->error(Error::CODE_KEY_FAILED);	
		}
		$key_res = $this->secret->get_field('secret_key', $key);
		if(!$key_res) {
			$this->error(Error::CODE_KEY_FAILED);
		}
		$this->apply_id = $key_res['apply_id'];
	}
	/**
	 * 接口申请验证
	 */
	public function applyVerify(){
		$apply_id = $this->apply_id;
		$apply_res = $this->apply->get_field('id', $apply_id);
		if(!$apply_res) {
			$this->error(Error::CODE_APPLY_FAILED);
		}
		if($apply_res['is_agree'] != '1') {
			$this->error(Error::CODE_APPLY_STATUS_ERROR);
		}
		$this->api_rate = $apply_res['rate'];
		$this->api_id=$apply_res['aid'];
		$this->user_id=$apply_res['uid'];	
	}
	/**
	 * 项目状态验证
	 */
	public function userVerify(){
		$user_id = $this->user_id;
		$user_res = $this->user->get_field('id', $user_id);
		if($user_res['status']==2) {
			$this->error(Error::CODE_USER_STATUS_ERROR);
		}
	}
	/**
	 * 接口状态验证
	 */
	public function apiVerify(){
		$api_id = $this->api_id;
		$api_res = $this->api->get_field('id', $api_id);
		if(!$api_res) {
			$this->error(Error::CODE_API_FAILED);
		}
		if($api_res['status'] == 2) {
			$this->error(Error::CODE_API_STATUS_ERROR);
		}
		$this->api_url=$api_res['api_url'];
	}
	/**
	 * 接口调用速率限制
	 * @param unknown $key
	 */
	public function rateVerify($key){
		$rate_obj = new \app\modules\api\redis\Rate();
		$rate = Yii::$app->params['rate_value'][$this->api_rate];
		if(!($rate_obj->check_rate($key, $rate))){
			$this->error(Error::CODE_API_RATE_ERROR);
		}
	}
	/**
	 * 接口调用统计
	 */
	public function apiStat($key){
		$rate_obj = new \app\modules\api\redis\Rate();
		@$rate_obj->stat($key);
	}
	/**
	 * 返回接口错误信息
	 * @param string $code
	 */
	public function error($code='10001'){
		$output = new Error($code);
		echo json_encode($output->toArray());
		exit;
	}
	
}