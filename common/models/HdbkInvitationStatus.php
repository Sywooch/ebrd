<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "hdbk_invitation_status".
 *
 * @property integer $id
 * @property string $name
 * @property string $comment
 *
 * @property Invitation[] $invitations
 */
class HdbkInvitationStatus extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'hdbk_invitation_status';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'name'], 'required'],
            [['id'], 'integer'],
            [['comment'], 'string'],
            [['name'], 'string', 'max' => 45],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('team', 'ID'),
            'name' => Yii::t('team', 'Name'),
            'comment' => Yii::t('team', 'Comment'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInvitations()
    {
        return $this->hasMany(Invitation::className(), ['status_id' => 'id']);
    }
}
