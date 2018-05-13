<?php

namespace common\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "team".
 *
 * @property integer $id
 * @property integer $owner_id
 * @property string $name
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Invitation[] $invitations
 * @property Order[] $orders
 * @property Profile[] $profiles
 * @property User $owner
 */
class Team extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'team';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['owner_id'], 'required'],
            [['owner_id'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['name'], 'string', 'max' => 255],
            [['owner_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['owner_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('team', 'ID'),
            'owner_id' => Yii::t('team', 'Owner ID'),
            'name' => Yii::t('team', 'Name'),
            'created_at' => Yii::t('team', 'Created At'),
            'updated_at' => Yii::t('team', 'Updated At'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInvitations()
    {
        return $this->hasMany(Invitation::className(), ['team_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrders()
    {
        return $this->hasMany(Order::className(), ['buyer_team_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProfiles()
    {
        return $this->hasMany(Profile::className(), ['current_team_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOwner()
    {
        return $this->hasOne(User::className(), ['id' => 'owner_id']);
    }
	
	/**
     * @return \yii\db\ActiveQuery
     */
    public function getTeams()
    {
		$teams = self::find()->orderBy('name')->all();
        return ArrayHelper::map($teams,'id','name');
    }
	
	public function getTeamName($id)
    {
		return self::find()->select(['name'])->where(['id' => $id])->scalar();
    }
	
	/**
	 * Just parent saving...
	 * 
	 * @return bool whether the saving succeeded (i.e. no validation errors occurred).
	 */
	public function parentSave(){
		return parent::save();
	}
	
}
