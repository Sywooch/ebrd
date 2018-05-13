<?php

namespace frontend\modules\catalog\models;

use Yii;

/**
 * This is the model class for table "catalog_method_analysis_data".
 *
 * @property int $id
 * @property string $name
 *
 * @property CatalogDocumentToMethodAnalisis[] $catalogDocumentToMethodAnalises
 */
class CatalogMethodAnalysisData extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'catalog_method_analysis_data';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'string', 'max' => 150],
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
    public function getCatalogDocumentToMethodAnalises()
    {
        return $this->hasMany(CatalogDocumentToMethodAnalisis::className(), ['method_analisis_id' => 'id']);
    }
	
	public static function getTranslatedAnalysisMethods($condition = NULL)
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
