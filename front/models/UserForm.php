<?php
namespace app\models;

use Yii;
use yii\base\Model;

/**
 * User form
 */
class UserForm extends Model
{
	
	public $username;
	public $password;
	public $status; // 1正常，2锁定
    public $project;
    public $department;
    public $qq;
    public $rememberMe = true;
    
    private $_userForm = false;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
        	// 添加
            // username and email are both required, create scenario
            [['username','password','project','department'], 'required', 'on' => 'create'],
            // 登录
            // username and password are both required
            [['username', 'password'], 'required', 'on' => 'login'],
            // rememberMe must be a boolean value
            ['rememberMe', 'boolean', 'on' => 'login'],
            // password is validated by validatePassword()
            ['password', 'validatePassword', 'on' => 'login'],
        ];
    }

    /**
     * (non-PHPdoc)
     * @see \yii\base\Model::scenarios()
     */
    public function scenarios() {
    	return [
    		// 场景，块赋值和验证规则
			'create' => ['username','password','project','department','qq'],
			'login' => ['username', 'password', 'rememberMe'],
    	];
    }
    
    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validatePassword($attribute, $params)
    {
    	if (!$this->hasErrors()) {
    		$user = $this->getUser();
    		if (!$user || !$user->validatePassword($this->password)){
    			$this->addError($attribute, 'Incorrect username or password.');
    		}
    	}
    }
    
    /**
     * 用户名是否存在，存在返回true，否则返回false
     * @return boolean
     */
    public function existUsername()
    {
    	$model = User::findOne(['username' => $this->username]);
    	if($model === null) {
    		return false;
    	}
    	return true;
    }
    
    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    public function getUser()
    {
    	if ($this->_userForm === false) {
    		$this->_userForm = User::findByUsername($this->username);
    	}
    
    	return $this->_userForm;
    }
    
}