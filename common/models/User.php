<?php
namespace common\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use common\models\AuthAssignment;
use frontend\modules\user\models\Profile;
use yii\helpers\ArrayHelper;
use frontend\modules\blog\models\BlogPost;
use frontend\modules\user\models\MapTeamUserReport;

/**
 * User model
 *
 * @property integer $id
 * @property string $email
 * @property string $reg_token
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $role
 * @property string $auth_key
 * @property integer $status_id
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $reg_token_expire
 * @property string $password write-only password
 */
class User extends ActiveRecord implements IdentityInterface
{
    const STATUS_DELETED = 0;
    const STATUS_AWAITING_EMAIL_CONFIRMATION = 5;
    const STATUS_ACTIVE = 10;
    const STATUS_BLOCKED = 20;



    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user}}';
    }

	/**
     * @inheritdoc
     */
    public function rules()
    {
        return [
			[['google_id','facebook_id', 'seo_member_status'], 'string'],
            ['status_id', 'default', 'value' => self::STATUS_AWAITING_EMAIL_CONFIRMATION],
            ['status_id', 'in', 'range' => [
				self::STATUS_AWAITING_EMAIL_CONFIRMATION, 
				self::STATUS_ACTIVE, 
				self::STATUS_DELETED, 
				self::STATUS_BLOCKED
			]],
        ];
    }
	
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
		return [
				[
				'class' => TimestampBehavior::className(),
				'value' => function($event){
					return date("Y-m-d H:i:s");
				}
			]
		];
    }
	
	public function getReports()
    {
        return $this->hasMany(MapTeamUserReport::className(), ['user_id' => 'id']);
    }
	
    public function getInvited()
    {
        return $this->hasMany(Invitation::className(), ['invited_id' => 'id']);
    }
	
	public function getStatus()
	{
		return $this->hasOne(\frontend\modules\user\models\HdbkUserStatus::className(), ['id' => 'status_id']);
	}
	
	public function getRoles()
	{
		return $this->hasMany(AuthAssignment::className(), ['user_id' => 'id']);
	}
	
	public function getProfile()
	{
		return $this->hasOne(Profile::className(), ['user_id' => 'id']);
	}
	
	public function getPosts()
	{
		return $this->hasMany(BlogPost::className(), ['author_id' => 'id']);
	}

	/**
     * Finds user by email
     *
     * @param string $email
     * @return static|null
     */
    public static function findByEmail($email)
    {
        return static::findOne(['email' => $email, 'status_id' => self::STATUS_ACTIVE]);
    }
	
	public static function getDemoUser()
    {
        return self::findOne(['email' => 'demo@demo.com']);
    }
	
	/**
     * Finds user by email
     *
     * @param string $email
     * @return static|null
     */
    public static function findByEmailNoStatus($email)
    {
        return static::findOne(['email' => $email]);
    }
	
    /**
    * Confirm email by reseting reg_token to empty string
    * and changing user status_id
    * 
    * @param string $token token for email confirmation - reg_token
    * @return bool if token was found and reseted to empty string
    */
    public static function confirmEmailByToken($token)
    {
		$user = self::findOne([
			'reg_token' => $token,
			'status_id' => self::STATUS_AWAITING_EMAIL_CONFIRMATION,
		]);

		if ((is_object($user)) && (strtotime($user->reg_token_expire) > time())){
			$user->reg_token = '';
			$user->reg_token_expire = NULL;
			$user->status_id = self::STATUS_ACTIVE;
			if (($user->save()) && (Yii::$app->user->login($user, 3600 * 24 * 30))){
				$user->touch('last_login');
				return TRUE;
			}
		}

		return FALSE;
    }
	
	public static function deleteUser($userId)
	{
		$user = self::findOne($userId);
		$user->status_id = self::STATUS_DELETED;
		$user->email = 'deleted_' . $user->email;
		return $user->save();
	}

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status_id' => self::STATUS_ACTIVE]);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne([
			'username' => $username, 
			'status_id' => [self::STATUS_ACTIVE]
		]);
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
            'status_id' => [self::STATUS_ACTIVE, self::STATUS_AWAITING_EMAIL_CONFIRMATION],
        ]);
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return bool
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }
        return true;
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }
	
	/**
     * @inheritdoc
     */
    public function getUserByResetToken($token)
    {
        return self::find()->select(['email'])->where(['password_reset_token' => $token])->one();
    }

	/**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }
	
	/**
	 * Deletes users that haven't confirmed their email in time
	 */
	public static function clearExpiredTokens()
	{
		$users = self::find()
			->where(['not in', 'status_id', self::STATUS_DELETED])
			->andWhere(['<', 'reg_token_expire', date('Y-m-d H:i:s')])
			->all();
		
		foreach ($users as $user){
			$user->delete();
		}
	}
	
	public function getUsersEmails()
    {
		$users = self::find()->orderBy('email')->all();
		return ArrayHelper::map($users,'id','email');
    }
	
	public function getActiveUsersEmails()
    {
		$users = self::find()->where(['status_id' => self::STATUS_ACTIVE])->orderBy('email')->all();
		return ArrayHelper::map($users,'id','email');
    }
	
	public static function getUserById($id)
    {
		$db = Yii::$app->db;
		return $db->cache(function ($db) use ($id) {
			
			return self::findOne($id);
		}, 3600);
		
    }
	
	public function getUsersById($id)
    {
		return self::find()->where(['id' => $id])->all();
    }
	
	public function getActiveUsersById($id)
    {
		return self::find()->where(['id' => $id, 'status_id' => self::STATUS_ACTIVE])->all();
    }
}
