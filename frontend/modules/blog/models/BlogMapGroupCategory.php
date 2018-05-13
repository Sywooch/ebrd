<?php

namespace frontend\modules\blog\models;

use Yii;

/**
 * This is the model class for table "blog_map_group_category".
 *
 * @property int $group_id
 * @property int $category_id
 */
class BlogMapGroupCategory extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'blog_map_group_category';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['group_id', 'category_id'], 'required'],
            [['group_id', 'category_id'], 'integer'],
            [['group_id', 'category_id'], 'unique', 'targetAttribute' => ['group_id', 'category_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'group_id' => Yii::t('blog', 'Group ID'),
            'category_id' => Yii::t('blog', 'Category ID'),
        ];
    }
}
