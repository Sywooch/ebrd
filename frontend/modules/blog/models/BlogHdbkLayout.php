<?php

namespace frontend\modules\blog\models;

use Yii;

/**
 * This is the model class for table "blog_hdbk_layout".
 *
 * @property integer $id
 * @property integer $type_id
 * @property string $name
 */
class BlogHdbkLayout extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'blog_hdbk_layout';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type_id'], 'integer'],
            [['name'], 'string', 'max' => 45],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('blog', 'ID'),
            'name' => Yii::t('blog', 'Name'),
			'layout_file' => Yii::t('blog', 'Layout File'),
			'comment' => Yii::t('blog', 'Comment'),
        ];
    }
	
	public function getLayouts()
    {
        return self::find()->all();
    }
	
	public function getCategories()
	{
		return $this->hasMany(BlogCategory::className(), ['layout_id' => 'id']);
	}
	
	public function getLayoutById($id)
    {
        return self::find()->where(['id' => $id])->all();
    }
}
