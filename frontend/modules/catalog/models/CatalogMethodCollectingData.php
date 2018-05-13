<?php

namespace frontend\modules\catalog\models;

use Yii;

/**
 * This is the model class for table "catalog_method_collecting_data".
 *
 * @property int $id
 * @property string $name
 *
 * @property CatalogDocumentToMethodCollecting[] $catalogDocumentToMethodCollectings
 */
class CatalogMethodCollectingData extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'catalog_method_collecting_data';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('catalog', 'ID'),
            'name' => Yii::t('catalog', 'Name'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCatalogDocumentToMethodCollectings()
    {
        return $this->hasMany(CatalogDocumentToMethodCollecting::className(), ['method_collecting_id' => 'id']);
    }
	
	public static function getTranslatedCollectingMethods($condition = NULL)
	{
		if(!empty($condition)) {
			$methods = self::find()
				->where($condition)
				->all();
		} else {
			$methods = self::find()->all();
		}
		$translatedMethods = [];
		foreach ($methods as $method){
			$translatedMethods[] = ['id' => $method->id, 'name' => Yii::t('catalog', $method->name)];
		}
		
		return $translatedMethods;
	}
}
