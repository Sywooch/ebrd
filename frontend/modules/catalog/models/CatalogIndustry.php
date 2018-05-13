<?php

namespace frontend\modules\catalog\models;

use Yii;

/**
 * This is the model class for table "catalog_industry".
 *
 * @property int $id
 * @property string $name
 *
 * @property CatalogDocument[] $catalogDocuments
 */
class CatalogIndustry extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'catalog_industry';
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
    public function getCatalogDocuments()
    {
        return $this->hasMany(CatalogDocument::className(), ['industry_id' => 'id']);
    }
	
	public static function getTranslatedIndustries()
	{
		$industries = self::find()->all();
		$translatedIndustries = [];
		foreach ($industries as $industry){
			$translatedIndustries[] = ['id' => $industry->id, 'name' => Yii::t('catalog', $industry->name)];
		}
		
		return $translatedIndustries;
	}
}
