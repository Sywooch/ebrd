<?php
namespace common\models;

use Yii;
use yii\base\Model;

/**
 * Login form
 */
class LoginForm extends Model
{
    public $email;
    public $password;
    public $rememberMe = true;

    private $_user;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // email and password are both required
            [['email', 'password'], 'required'],
            // rememberMe must be a boolean value
            ['rememberMe', 'boolean'],
            // password is validated by validatePassword()
            ['password', 'validatePassword'],
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
			if(empty($user)){
				$result = false;
			}else{
				if($user->status_id == User::STATUS_ACTIVE && empty($user->auth_key)){
					$result = true;
				}else{
					$result = false;
				}
			}
			if($result){
				$this->addError($attribute, Yii::t('blog','YOU_WAS_AUTH_SOCIAL'));
			}else{
				if (!$user || !$user->validatePassword($this->password)) {
					$this->addError($attribute, Yii::t('blog','INCORRECT_EMAIL_PASSWORD'));
				}
			}
        }
    }

    /**
     * Logs in a user using the provided username and password.
     *
     * @return bool whether the user is logged in successfully
     */
    public function login()
    {
        if ($this->validate()) {
			$user = $this->getUser();
			$user->touch('last_login');
            return Yii::$app->user->login($user, $this->rememberMe ? 3600 * 24 * 30 : 0);
        } else {
            return false;
        }
    }
	
	public function loginAdmin()
    {
        if ($this->validate()) {
			$user = $this->getUser();
			if ($user->role === 7){
				return Yii::$app->user->login($user, $this->rememberMe ? 3600 * 24 * 30 : 0);				
			}
        } else {
            return false;
        }
    }

    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    protected function getUser()
    {
        if ($this->_user === null) {
            $this->_user = User::findByEmail($this->email);
        }

        return $this->_user;
    }
	
	public function loginTcoTmp($tmpUserTco)
    {
			$user = $tmpUserTco;
			$user->touch('last_login');
            return Yii::$app->user->login($user, $this->rememberMe ? 3600 * 24 * 30 : 0);
    }
}
