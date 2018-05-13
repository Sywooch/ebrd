<?php

namespace frontend\modules\plugins\models;

use Yii;

/**
 * This is the model class for table "shortcode_info".
 *
 * @property integer $id
 * @property integer $shortcode_id
 * @property string $tag
 * @property string $description
 */
class ShortcodeInfo extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'shortcode_info';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['shortcode_id'], 'integer'],
            [['description'], 'string'],
            [['tag'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('plugins', 'ID'),
            'shortcode_id' => Yii::t('plugins', 'Shortcode ID'),
            'tag' => Yii::t('plugins', 'Tag'),
            'description' => Yii::t('plugins', 'Description'),
        ];
    }
}
