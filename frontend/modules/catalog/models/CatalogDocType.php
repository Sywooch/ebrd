<?php

namespace frontend\modules\catalog\models;

use Yii;

/**
 * This is the model class for table "catalog_doc_type".
 *
 * @property int $id
 * @property string $name
 * @property int $period
 *
 * @property CatalogDocument[] $catalogDocuments
 */
class CatalogDocType extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'catalog_doc_type';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'string', 'max' => 150],
            [['period'], 'string', 'max' => 1],
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
            'period' => Yii::t('catalog', 'Period'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCatalogDocuments()
    {
        return $this->hasMany(CatalogDocument::className(), ['doc_type_id' => 'id']);
    }
	
	public static function getTranslatedDoctypes()
	{
		$doctypes = self::find()->all();
		$translatedDoctypes = [];
		foreach ($doctypes as $doctype){
			$translatedDoctypes[] = ['id' => $doctype->id, 'name' => Yii::t('catalog', $doctype->name)];
		}
		
		return $translatedDoctypes;
	}
}
