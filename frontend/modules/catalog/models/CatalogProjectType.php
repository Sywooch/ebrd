<?php

namespace frontend\modules\catalog\models;

use Yii;

/**
 * This is the model class for table "catalog_project_type".
 *
 * @property int $id
 * @property string $name
 *
 * @property CatalogDocumentToProject[] $catalogDocumentToProjects
 */
class CatalogProjectType extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'catalog_project_type';
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
    public function getCatalogDocumentToProjects()
    {
        return $this->hasMany(CatalogDocumentToProject::className(), ['project_type_id' => 'id']);
    }
	
	public static function getTranslatedProjectTypes($condition = NULL)
	{
		if(!empty($condition)) {
			$types = self::find()
				->where($condition)
				->all();
		} else {
			$types = self::find()->all();
		}
		$translatedTypes = [];
		foreach ($types as $type){
			$translatedTypes[] = ['id' => $type->id, 'name' => Yii::t('catalog', $type->name)];
		}
		
		return $translatedTypes;
	}
}
