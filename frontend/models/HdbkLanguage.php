<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "hdbk_language".
 *
 * @property integer $id
 * @property string $code
 * @property string $name
 * @property string $native_name
 * @property integer $is_default
 * @property integer $is_active
 *
 * @property BlogCategory[] $blogCategories
 * @property BlogPost[] $blogPosts
 * @property BlogTag[] $blogTags
 */
class HdbkLanguage extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'hdbk_language';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['code', 'name'], 'required'],
            [['is_default', 'is_active'], 'integer'],
            [['code'], 'string', 'max' => 5],
            [['name', 'native_name'], 'string', 'max' => 45],
            [['code'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('blog', 'ID'),
            'code' => Yii::t('blog', 'LANGUAGE_CODE'),
            'name' => Yii::t('blog', 'Name'),
            'native_name' => Yii::t('blog', 'Native Name'),
            'is_default' => Yii::t('blog', 'Is Default'),
            'is_active' => Yii::t('blog', 'Is Active'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBlogCategories()
    {
        return $this->hasMany(BlogCategory::className(), ['lang_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBlogPosts()
    {
        return $this->hasMany(BlogPost::className(), ['lang_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBlogTags()
    {
        return $this->hasMany(BlogTag::className(), ['lang_id' => 'id']);
    }
	
	/**
	 * Default application language
	 * @return \frontend\models\HdbkLanguage
	 */
	public static function getDefaultLanguage()
	{
		return self::findOne(['is_default' => 1]);
	}

	public static function getLanguagesSymbols()
	{
		$db = Yii::$app->db;
		return $db->cache(function ($db) {
			
			return self::find()
				->where(['is_active' => 1])
				->all();
		}, 3600);
	}
	
	public static function getLanguagesKeyValue()
	{
		$activeLangsObj = self::find()
			->where(['is_active' => 1])
			->all();
		
		$langs = [];
		
		foreach ($activeLangsObj as $activeLang){
			$langs[$activeLang->id] = $activeLang->code;
		}
		
		return $langs;
		
	}

	/**
	 * 
	 * @return array Of active languages codes
	 */
	public static function getLanguagesSymbolsArray()
	{
		$db = Yii::$app->db;
		return $db->cache(function ($db) {
		
			return self::find()
				->select(['code'])
				->where(['is_active' => 1])
				->column();
		}, 3600);
	}
	
	/**
	 * 
	 * @return string Code of default application language
	 */
	public static function getDefaultLanguageCode()
	{
		$db = Yii::$app->db;
		return $db->cache(function ($db) {
		
			return self::find()
				->select(['code'])
				->where(['is_default' => 1])
				->scalar();
		}, 3600);
	}
	
	public static function getDefaultLanguageId()
	{
		$db = Yii::$app->db;
		return $db->cache(function ($db) {
		
			return self::find()
				->select('id')
				->where(['is_default' => 1])
				->scalar();
		}, 3600);
	}
	
	public static function getLanguageByCode($code)
	{
		$db = Yii::$app->db;
		return $db->cache(function ($db) use ($code) {
			
			return self::findOne(['code' => $code]);
		}, 3600);
	}
	
	public static function getLanguageById($id)
	{
		return self::find()
				->select(['code','name'])
				->where(['id' => $id])
				->one();
				
	}
	
	public static function getOptionLanguages($languages, $defaultLanguage, $usedCodes)
	{
		$items = [$defaultLanguage->id => $defaultLanguage->name];
		foreach ($languages as $lang){
			if (in_array($lang->code, $usedCodes)){
				$items[$lang->id] = $lang->name;
			}
		}
		return $items;
	}
	
	/**
	 * Find language id by language code
	 * 
	 * @param string $code
	 * @return integer
	 */
	public static function getLangIdByCode($code)
	{
		$lang = self::findOne(['code' => $code]);
		
		return $lang->id;
	}
	
	public static function getLangCodeById($id)
	{
		$db = Yii::$app->db;
		return $db->cache(function ($db) use ($id) {
			
			return self::findOne($id)->code;
		}, 3600);
	}
}
