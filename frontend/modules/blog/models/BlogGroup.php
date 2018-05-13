<?php

namespace frontend\modules\blog\models;

use frontend\modules\blog\interfaces\Publishable;
use frontend\modules\blog\models\BlogCategory;
use frontend\modules\blog\models\BlogHdbkStatus;
use frontend\models\HdbkLanguage;
use yii\helpers\ArrayHelper;
use Yii;

/**
 * This is the model class for table "blog_group".
 *
 * @property int $id
 * @property string $name
 * @property string $url
 * @property int $lang_id
 * @property string $created_at
 * @property string $updated_at
 */
class BlogGroup extends \yii\db\ActiveRecord implements Publishable
{
	
	public $thumbnail;

	const TRANS_FIELDS = [
		'name',
		'title',
		'url',
	];

	/**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'blog_group';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'lang_id'], 'required'],
            [['lang_id', 'status_id'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['name', 'url', 'title'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('blog', 'ID'),
            'name' => Yii::t('blog', 'NAME'),
            'lang_id' => Yii::t('blog', 'LANGUAGE'),
            'created_at' => Yii::t('blog', 'CREATED_AT'),
            'updated_at' => Yii::t('blog', 'UPDATED_AT'),
			'title' => Yii::t('blog', 'TITLE'),
			'url' => Yii::t('blog', 'URL'),
        ];
    }
	
	/**
     * @inheritdoc
     */
    public function behaviors()
    {
		return [
				[
				'class' => \yii\behaviors\TimestampBehavior::className(),
				'value' => function($event){
					return date("Y-m-d H:i:s");
				}
			]
		];
    }
	
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLang()
    {
        return $this->hasOne(HdbkLanguage::className(), ['id' => 'lang_id']);
    }
	
	public function getCategories()
	{
		return $this->hasMany(BlogCategory::className(), ['group_id' => 'id']);
	}
	
	public function getStatus()
	{
		return $this->hasOne(BlogHdbkStatus::className(), ['id' => 'status_id']);
	}
        
    public static function getGroup($id)
	{
		return self::find()
			->where(['id' => $id])
			->all();
	}
	
	public static function getGroupPublished($id)
	{
		return self::find()
			->where(['id' => $id, 'status_id' => 11])
			->one();
	}
	
	public static function getCategoriesPublished($id)
	{
		return self::find()
			->where(['blog_category.group_id' => $id, 'blog_group.status_id' => 11])
			->joinWith('categories')
			->all();
	}
	
	public static function getGroups($params = [])
	{
		$query = self::find();
		
		if (!empty($params['lang_id'])){
			$query->where(['lang_id' => $params['lang_id']]);
		}
		
		$query->orderBy(['name' => SORT_ASC]);
		
		return $query->all();
	}	
	
        public static function getGroupsCreate()
	{
		return self::find()
			->select(['id', 'name'])
                        ->where(['lang_id' => Yii::$app->params['settings']['defaultLangObj']['id']])
                        ->orderBy('name')
			->all();
	}
		
	public function getTranslationTemplate($langId)
	{
		$target = new self();
		$target->lang_id = $langId;

		foreach (self::TRANS_FIELDS as $field){
			$target->{$field}  = $this->{$field};
		}

		$target->parentSave();

		return $target;
	}
		
	/**
	 * Just parent saving...
	 * 
	 * @return bool whether the saving succeeded (i.e. no validation errors occurred).
	 */
	public function parentSave(){
		return parent::save();
	}
	
	/**
	 * Removes all html and php tags from fields, that not equal to 'content'
	 */
	public function prepareForSaving()
	{
		$fields = self::TRANS_FIELDS;
		foreach ($fields as $field){
			if ($field !== 'content'){
				$this->{$field} = strip_tags($this->{$field});
			}
		}
	}
	
	public function saveUpdatedGroup(){
		$postSource = BlogGroup::find()
				->select('lang_id')
				->where(['id' => $this->id])
				->scalar();
		$sourceLangCode = HdbkLanguage::getLanguageById($postSource)->code;

		$translationSource = BlogMapEntityLang::getTranslationGroupRow($this->id, $sourceLangCode);
		$translationSource->{$sourceLangCode} = NULL;
		$translationSource->save();
		$this->save();

		return $this->save();
	}
	
	
	public function save($runValidation = true, $attributeNames = NULL){
		return parent::save($runValidation = true, $attributeNames = NULL) && $this->saveGroupLangChain();
	}
	
	public function saveGroupLangChain(){
		$translation = BlogMapEntityLang::getTranslationGroupRow($this->id, $this->lang->code);
		
		if (!empty(Yii::$app->request->post())){
			$request = Yii::$app->request->post();
		}
		
		$translationRowIdInt = (!empty($request['BlogMapEntityLang']['id'])) ? $request['BlogMapEntityLang']['id'] : 0;

		if(empty($translation) && ($translationRowIdInt !== 0)){
			$translation = BlogMapEntityLang::findOne($translationRowIdInt);
			$languages = HdbkLanguage::getLanguageById($request["BlogGroup"]['lang_id']);

			if(empty(Yii::$app->request->get()['translate_to'])){
				$translation->{$languages->code} = $this->id;
			}else{
				$translation->{$this->lang->code} = $this->id;
			}
		}elseif (empty ($translation)){
			$translation = new BlogMapEntityLang();
			$translation->{$this->lang->code} = $this->id;
		}
		$translation->entity_type_id = 3;
		if ($translation->save()){
			return true;
		}else{
			return false;
		}
	}
	
	public function delete(){
		return parent::delete() && $this->deleteEntityChain(); 
	}
	
	public function deleteEntityChain()
	{
		$lang_array = Yii::$app->params['settings']['supportedLanguages'];
		$deleteEntityChain = BlogMapEntityLang::getTranslationGroupRow($this->id, $this->lang->code);
		$deleteEntityChain{$this->lang->code} = NULL;
		$deleteEntityChain->save();
		$idOfEnityChain = [];
		foreach ($lang_array as $lang){
			if(!empty($deleteEntityChain{$lang})){
				array_push($idOfEnityChain, $deleteEntityChain{$lang});
			}
		}

		if(sizeof($idOfEnityChain) == 0){
			$deleteEntityChain->delete();
		}
	}
	
	public function getTranslatedGroup($old_model, $translate_to)
	{
		$translatedRow = BlogMapEntityLang::getTranslationGroupRow($old_model->group_id, HdbkLanguage::getLanguageById($old_model->lang_id)->code);
		
		$groups =  self::find()
				->select(['id','name'])
				->where(['lang_id' => HdbkLanguage::getLanguageByCode($translate_to)])
				->orderBy('name')
				->all();
		
		$groupsArray = ArrayHelper::map($groups,'id','name');
		
		if(!empty($translatedRow[$translate_to])){
			$translationGroup = self::getGroup($translatedRow[$translate_to]);
			unset($groupsArray[$translationGroup[0]->id]);
			$translationGroupArray = [$translationGroup[0]['id'] => $translationGroup[0]['name']];
			$groupsArray = $translationGroupArray + $groupsArray;
		}
		
		return $groupsArray;
	}
	
	public function getTranslationFlag($old_model, $translate_to)
	{
		$flag = FALSE; 
		
		if(!empty($old_model->group_id)){
			$translatedRow = BlogMapEntityLang::getTranslationGroupRow($old_model->group_id, HdbkLanguage::getLanguageById($old_model->lang_id)->code);
			if(!empty($translatedRow[$translate_to])){
				$flag = TRUE;
			}
		}
		
		return $flag;
	}
}
