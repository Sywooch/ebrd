<?php

namespace frontend\modules\blog\models;

use Yii;

/**
 * This is the model class for table "blog_map_post_tag".
 *
 * @property integer $post_id
 * @property integer $tag_id
 *
 * @property BlogPost $post
 * @property BlogTag $tag
 */
class BlogMapPostTag extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'blog_map_post_tag';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['post_id', 'tag_id'], 'required'],
            [['post_id', 'tag_id'], 'integer'],
            [['post_id'], 'exist', 'skipOnError' => true, 'targetClass' => BlogPost::className(), 'targetAttribute' => ['post_id' => 'id']],
            [['tag_id'], 'exist', 'skipOnError' => true, 'targetClass' => BlogTag::className(), 'targetAttribute' => ['tag_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'post_id' => Yii::t('blog', 'Post ID'),
            'tag_id' => Yii::t('blog', 'Tag ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPost()
    {
        return $this->hasOne(BlogPost::className(), ['id' => 'post_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTag()
    {
        return $this->hasOne(BlogTag::className(), ['id' => 'tag_id']);
    }
}
