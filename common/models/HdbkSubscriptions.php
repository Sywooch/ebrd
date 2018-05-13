<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "hdbk_subscriptions".
 *
 * @property integer $id
 * @property string $name
 * @property string $comment
 */
class HdbkSubscriptions extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'hdbk_subscriptions';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name', 'comment'], 'string', 'max' => 300],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'comment' => Yii::t('app', 'Comment'),
        ];
    }
}
