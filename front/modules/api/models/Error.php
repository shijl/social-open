<?php
namespace app\modules\api\models;

use yii\base\Object;

/**
 * Error错误信息类
 */
class Error extends Object
{
	// 公共错误
	const CODE_UNKNOWN_ERROR = 10001; // 未知错误
	const CODE_KEY_FAILED = 10002; // 非法密钥
	const CODE_APPLY_FAILED = 10003;  // 申请记录不存在
	const CODE_APPLY_STATUS_ERROR = 10004; //接口未通过审核
	const CODE_API_FAILED = 10005; //接口不存在
	const CODE_API_STATUS_ERROR = 10006; // 接口已停用
	const CODE_API_RATE_ERROR = 10007; // 接口请求次数过多
	const CODE_USER_STATUS_ERROR = 10008;

	
	private static $messages = [
		self::CODE_UNKNOWN_ERROR => '未知错误',
		self::CODE_KEY_FAILED => '非法密钥',
		self::CODE_APPLY_FAILED => '申请记录不存在',
		self::CODE_APPLY_STATUS_ERROR => '接口未通过审核',
		self::CODE_API_FAILED => '接口不存在',
		self::CODE_API_STATUS_ERROR => '接口已停用',
		self::CODE_API_RATE_ERROR => '接口请求次数过多',
		self::CODE_USER_STATUS_ERROR =>'项目状态已锁定',
	];
	
	public $code;
	public $message;
	
	public function __construct($code, $message = null) {
		if(isset($code) && !empty($code)) {
			$this->code = $code;
		}
		else {
			$this->code = self::CODE_UNKNOWN_ERROR;
		}
		if(isset($message) && !empty($message)) {
			$this->message = $message;
		}
		else {
			$this->message = $this->getMessage($this->code);
		}
	}
	
	/**
	 * 获取消息
	 * @param number $code
	 * @return Ambigous <string>
	 */
	public function getMessage($code = 10001) {
		return self::$messages[$code];
	}
	
	/**
	 * 返回错误信息的数组
	 * @return array
	 */
	public function toArray() {
		return ['error' => ['code' => $this->code, 'message' => $this->message]];
	}
	
}