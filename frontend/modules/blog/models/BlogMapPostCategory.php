<?php

namespace frontend\modules\blog\models;

use Yii;

/**
 * This is the model class for table "blog_map_post_category".
 *
 * @property integer $post_id
 * @property integer $category_id
 *
 * @property BlogCategory $category
 * @property BlogPost $post
 */
class BlogMapPostCategory extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'blog_map_post_category';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['post_id', 'category_id'], 'required'],
            [['post_id', 'category_id'], 'integer'],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => BlogCategory::className(), 'targetAttribute' => ['category_id' => 'id']],
            [['post_id'], 'exist', 'skipOnError' => true, 'targetClass' => BlogPost::className(), 'targetAttribute' => ['post_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'post_id' => Yii::t('blog', 'Post ID'),
            'category_id' => Yii::t('blog', 'Category ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(BlogCategory::className(), ['id' => 'category_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPost()
    {
        return $this->hasOne(BlogPost::className(), ['id' => 'post_id']);
    }
}
