<?php

namespace frontend\modules\blog\models;

use Yii;

/**
 * This is the model class for table "blog_tag".
 *
 * @property integer $id
 * @property string $alias
 * @property string $name
 * @property integer $lang_id
 * @property string $created_at
 * @property string $updated_at
 *
 * @property BlogMapPostTag[] $blogMapPostTags
 * @property HdbkLanguage $lang
 */
class BlogTag extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'blog_tag';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'lang_id'], 'required'],
            [['lang_id'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['alias'], 'string', 'max' => 45],
            [['name'], 'string', 'max' => 255],
            [['lang_id'], 'exist', 'skipOnError' => true, 'targetClass' => HdbkLanguage::className(), 'targetAttribute' => ['lang_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('blog', 'ID'),
            'alias' => Yii::t('blog', 'Alias'),
            'name' => Yii::t('blog', 'Name'),
            'lang_id' => Yii::t('blog', 'Lang ID'),
            'created_at' => Yii::t('blog', 'Created At'),
            'updated_at' => Yii::t('blog', 'Updated At'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBlogMapPostTags()
    {
        return $this->hasMany(BlogMapPostTag::className(), ['tag_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLang()
    {
        return $this->hasOne(HdbkLanguage::className(), ['id' => 'lang_id']);
    }
}
