<?php

namespace frontend\modules\blog\components\widgets\votes\model;

use Yii;

/**
 * This is the model class for table "votes".
 *
 * @property int $id
 * @property int $category_id
 * @property int $blog_post_id
 * @property int $ip
 * @property double $rating
 */
class Vote extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'votes';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ip', 'rating'], 'required'],
            [['category_id', 'blog_post_id'], 'integer'],
			[['ip'], 'string'],
            [['rating'], 'number'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'category_id' => 'Category Id',
			'blog_post_id' => 'Blog post Id',
            'ip' => 'Ip',
            'rating' => 'Rating',
        ];
    }
}
