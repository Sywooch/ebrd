<?php

namespace frontend\modules\blog\models;

use Yii;

/**
 * This is the model class for table "blog_event_status".
 *
 * @property int $id
 * @property string $name
 *
 * @property BlogMapEventUser[] $blogMapEventUsers
 */
class BlogEventStatus extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'blog_event_status';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 45],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBlogMapEventUsers()
    {
        return $this->hasMany(BlogMapEventUser::className(), ['status' => 'id']);
    }
}
