<?php

namespace frontend\modules\blog\models;

use frontend\modules\blog\models\BlogHdbkEntity;
use yii\helpers\Html;
use Yii;

/**
 * This is the model class for table "blog_hdbk_status".
 *
 * @property integer $id
 * @property string $name
 * @property string $description
 */
class BlogHdbkStatus extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'blog_hdbk_status';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['description'], 'string'],
            [['name'], 'string', 'max' => 255],
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
            'description' => Yii::t('blog', 'Description'),
        ];
    }
	
	
	public static function getStatuses($params = [])
	{
		$query = self::find(); 
		
		return $query->all();
	}
	
	public static function getTranslatedStatuses()
	{
		$statuses = self::find()->all();
		$translatedStatuses = [];
		foreach ($statuses as $status){
			$translatedStatuses[$status->id] = Yii::t('blog', $status->name);
		}
		
		return $translatedStatuses;
	}

	public static function getButtonForPublication($model)
	{
		return Html::button(Yii::t('blog', 'MARK AS READY FOR PUBLISHING'),
			[
				'class' => 'btn btn-warning',
				'id' => 'change_status',
				'data-entityId' => $model->id,
				'data-entityTypeId' => BlogHdbkEntity::getEntityId($model),
				'data-statusId' => BlogHdbkStatus::findOne(['name' => 'FOR_CONFIRMATION'])->id,
			]);
	}
	
	public static function getButtonToDraft($model)
	{
		return Html::button(Yii::t('blog', 'MARK AS DRAFT'),
			[
				'class' => 'btn btn-warning',
				'id' => 'change_status',
				'data-entityId' => $model->id,
				'data-entityTypeId' => BlogHdbkEntity::getEntityId($model),
				'data-statusId' => BlogHdbkStatus::findOne(['name' => 'DRAFT'])->id,		
			]);
	}
}
