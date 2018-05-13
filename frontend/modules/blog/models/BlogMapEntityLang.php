<?php

namespace frontend\modules\blog\models;

use Yii;

/**
 * This is the model class for table "blog_map_entity_lang".
 *
 * @property integer $id
 * @property integer $entity_type_id
 * @property integer $en
 * @property integer $pl
 * @property integer $tr
 * @property integer $uk
 * @property integer $zh
 */
class BlogMapEntityLang extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'blog_map_entity_lang';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id','entity_type_id', 'en', 'pl', 'tr', 'uk', 'zh'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('blog', 'ID'),
            'entity_type_id' => Yii::t('blog', 'Entity Type ID'),
            'en' => Yii::t('blog', 'En'),
            'pl' => Yii::t('blog', 'Pl'),
            'tr' => Yii::t('blog', 'Tr'),
            'uk' => Yii::t('blog', 'Uk'),
            'zh' => Yii::t('blog', 'Zh'),
        ];
    }
	
	public static function getTranslationRow($id, $lang_code){
		return self::find()
				->where([
					'entity_type_id' => 1,
					$lang_code => $id
				])
				->one();
	}
	
	public static function getTranslationCatRow($id, $lang_code){
		return self::find()
				->where([
					'entity_type_id' => 2,
					$lang_code => $id
				])
				->one();
	}
	
	/**
	 * 
	 * @param integer $id
	 * @param string $lang_code
	 * @return frontend\modules\blog\models\BlogMapEntityLang
	 */
	public static function getTranslationGroupRow($id, $lang_code){
		return self::find()
				->where([
					'entity_type_id' => 3,
					$lang_code => $id
				])
				->one();
	}

    /**
     * Get row with letter translations
     * @param $id
     * @param $lang_code
     * @return array|null|\yii\db\ActiveRecord
     */
    public static function getTranslationLetterRow($id, $lang_code){
        return self::find()
            ->where([
                'entity_type_id' => 4,
                $lang_code => $id
            ])
            ->one();
    }
	
	public static function getTranslationClumns($translateRow){
		return self::find()
				->where(['id' => $translateRow->id])
				->all();
	}
	
	public static function getRow($entityId, $id, $langCode)
	{
		return self::findOne([
			'entity_type_id' => $entityId,
			$langCode => $id,
		]);
	}
	
	public static function getEmptyColTranslationArray($translateRow)
	{
		$translateEmptyRow = self::getTranslationClumns($translateRow);
		$emptyColTranslationArray = [];

		if(!empty($translateEmptyRow)){
			foreach ($translateEmptyRow[0] as $key => $value){
				if(empty($value)){
					array_push($emptyColTranslationArray, $key);
				}
			}
		}
		return $emptyColTranslationArray;
	}
	
	public static function getUsedCodes($translateRow)
	{
		$usedCodes = [];
		foreach ($translateRow as $key => $val){
			if (empty($val)){
				$usedCodes[] = $key;
			}
		}
		return $usedCodes;
	}
	
	public static function getTranslationBtns($languages, $translateRow, $usedCodes)
	{
		//$translateEmptyRow = self::getTranslationClumns($translateRow);
		$langCodesWithTranslation = [];
		foreach ($languages as $lang){
			if (!in_array($lang->code, $usedCodes)){
				array_push($langCodesWithTranslation, $lang->code);
			}
		}
		$translateEmptyRow = self::find()
				->select($langCodesWithTranslation)
				->where(['id' => $translateRow->id])
				->one();
		
		foreach ($translateEmptyRow as $key => $value){
			if (!empty($value)){
				$translateEmpty[$key] = $value;
			}
		}
		return $translateEmpty;
	}
}
