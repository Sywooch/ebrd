<?php

namespace frontend\modules\blog\models;

use Yii;

/**
 * This is the model class for table "blog_hdbk_entity".
 *
 * @property integer $id
 * @property string $entity
 * @property string $class_name
 * @property string $table
 * @property string $comment
 */
class BlogHdbkEntity extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'blog_hdbk_entity';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['entity'], 'required'],
            [['comment', 'class_name', 'table'], 'string'],
            [['entity'], 'string', 'max' => 45],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('blog', 'ID'),
            'entity' => Yii::t('blog', 'Entity'),
            'comment' => Yii::t('blog', 'Comment'),
        ];
    }
	
	public static function getEntityId($model)
	{
		return self::find()
			->select(['id'])
			->where(['class_name' => $model::className()])
			->scalar();
	}
}
