<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "auth_assignment".
 *
 * @property string $item_name
 * @property string $user_id
 * @property integer $created_at
 *
 * @property AuthItem $itemName
 */
class AuthAssignment extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'auth_assignment';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['item_name', 'user_id'], 'required'],
            [['created_at'], 'integer'],
            [['item_name', 'user_id'], 'string', 'max' => 64],
            [['item_name'], 'exist', 'skipOnError' => true, 'targetClass' => AuthItem::className(), 'targetAttribute' => ['item_name' => 'name']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'item_name' => Yii::t('user', 'Item Name'),
            'user_id' => Yii::t('user', 'User ID'),
            'created_at' => Yii::t('user', 'Created At'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getItemName()
    {
        return $this->hasOne(AuthItem::className(), ['name' => 'item_name']);
    }
	
	/**
	 * Assigns role to user
	 * 
	 * @param integer $userId
	 * @param string $roleName
	 */
	public static function assignRole($userId, $roleName)
	{
		if (($roleName == 'superuser') && (!Yii::$app->user->can('manageSuperusers'))){
			throw new \yii\web\HttpException(403, Yii::t('user', 'YOU HAVE NOT ANOUGH RULES FOR THIS ACTION'));
		} else {
			$auth = Yii::$app->authManager;
			$role = $auth->getRole($roleName);
			return $auth->assign($role, $userId);
		}
		
	}
	
	/**
	 * Revokes role from user
	 * 
	 * @param integer $userId
	 * @param string $roleName
	 */
	public static function revokeRole($userId, $roleName)
	{
		if (($roleName == 'superuser') && (!Yii::$app->user->can('manageSuperusers'))){
			throw new \yii\web\HttpException(403, Yii::t('user', 'YOU HAVE NOT ANOUGH RULES FOR THIS ACTION'));
		} else {
			$auth = Yii::$app->authManager;
			$role = $auth->getRole($roleName);
			return $auth->revoke($role, $userId);
		}
		
	}
	
	/**
	 * Finds all all user IDs to whom the role is assigned
	 * 
	 * @param string $role
	 * @return array of user_id
	 */
	public static function getRoleUserIds($role)
	{
		return self::find()
			->select(['user_id'])
			->where(['item_name' => $role])
			->column();
	}
	
	public static function getRoleUserId($id)
	{
		return self::find()
			->select(['item_name'])
			->where(['user_id' => $id])
			->column();
	}
}
