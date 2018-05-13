<?php

namespace frontend\modules\blog\models;

use common\models\User;
use Yii;

/**
 * This is the model class for table "blog_map_event_user".
 *
 * @property int $user_id
 * @property int $event_id
 * @property int $status_id
 *
 * @property BlogEvent $event
 * @property User $user
 * @property BlogEventStatus $status
 */
class BlogMapEventUser extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'blog_map_event_user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'event_id','status'], 'required'],
            [['user_id', 'event_id','status'], 'integer'],
            [['user_id', 'event_id'], 'unique', 'targetAttribute' => ['user_id', 'event_id']],
            [['event_id'], 'exist', 'skipOnError' => true, 'targetClass' => BlogEvent::className(), 'targetAttribute' => ['event_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
            [['status'], 'exist', 'skipOnError' => true, 'targetClass' => BlogEventStatus::className(), 'targetAttribute' => ['status' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'user_id' => 'User ID',
            'event_id' => 'Event ID',
            'status' => 'Status ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEvent()
    {
        return $this->hasOne(BlogEvent::className(), ['id' => 'event_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStatus()
    {
        return $this->hasOne(BlogEventStatus::className(), ['id' => 'status']);
    }
}
