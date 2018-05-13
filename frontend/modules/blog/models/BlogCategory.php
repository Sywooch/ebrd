<?php

namespace frontend\modules\blog\models;

use frontend\components\Functions;
use frontend\models\HdbkLanguage;
use frontend\modules\blog\models\BlogHdbkStatus;
use frontend\modules\blog\models\BlogPost;
use frontend\modules\blog\interfaces\Publishable;
use frontend\modules\blog\models\BlogHdbkLayout;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use frontend\models\Redirects;
use Yii;

/**
 * This is the model class for table "blog_category".
 *
 * @property integer $id
 * @property string $alias
 * @property string $name
 * @property string $menu_section
 * @property string $title
 * @property string $description
 * @property integer $lang_id
 * @property integer $parent_category_id
 * @property integer $gourp_id
 * @property string $content
 * @property integer $status_id
 * @property string $created_at
 * @property string $updated_at
 * @property string $shortcodes
 * @property HdbkLanguage $lang
 * @property BlogCategory $cat
 * @property BlogMapPostCategory[] $blogMapPostCategories
 */
class BlogCategory extends \yii\db\ActiveRecord implements Publishable
{
	
	const TRANS_FIELDS = [
			'name',
			'menu_section',
			'title',
			'description',
			'content'
		];
	
	public $type;
	public $postsearch;
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
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'blog_category';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'lang_id', 'parent_category_id', 'alias', 'menu_section', 'title'], 'required'],
            [['last_news','lang_id', 'thumbnail', 'parent_category_id', 'group_id', 'status_id', 'layout_id'], 'integer'],
            [['posts_id','content','thumbnail_alt','shortcodes'], 'string'],
            [['created_at', 'updated_at', 'postsearch'], 'safe'],
			[
				'alias',
				'match',
				'pattern' => '/^[a-z0-9-]+$/',
				'message' => Yii::t('blog', 'YOU CAN USE ONLY LOWER CASE, NUMBERS AND "-"')
			],
            [['alias'], 'string', 'max' => 45],
            [['name', 'description'], 'string', 'max' => 255],
            [
				['lang_id'],
				'exist',
				'skipOnError' => true,
				'targetClass' => HdbkLanguage::className(),
				'targetAttribute' => ['lang_id' => 'id']
			],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('blog', 'ID'),
            'alias' => Yii::t('blog', 'ALIAS'),
            'name' => Yii::t('blog', 'NAME'),
			'menu_section' => Yii::t('blog', 'MENU_SECTION'),
			'title' => Yii::t('blog', 'TITLE'),
            'description' => Yii::t('blog', 'DESCRIPTION'),
            'lang_id' => Yii::t('blog', 'LANGUAGE'),
            'parent_category_id' => Yii::t('blog', 'PARENT_CATEGORY'),
			'group_id' => Yii::t('blog', 'GROUP'),
			'status_id' => Yii::t('blog', 'STATUS'),
            'content' => Yii::t('blog', 'CONTENT'),
            'created_at' => Yii::t('blog', 'CREATED_AT'),
            'updated_at' => Yii::t('blog', 'UPDATED_AT'),
			'thumbnail' => Yii::t('blog', 'THUMBNAIL'),
			'thumbnail_alt' => Yii::t('blog', 'THUMBNAIL_ALT'),
			'layout_id' => Yii::t('blog', 'LAYOUT'),
			'last_news' => Yii::t('blog', 'LAST_NEWS'),
			'posts_id'=> Yii::t('blog', 'POSTS'),
			'shortcodes' => Yii::t('blog', 'SHORTCODE_NAME'),
			'postsearch' => Yii::t('blog', 'POST_SEARCH')
        ];
    }
	
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLang()
    {
        return $this->hasOne(HdbkLanguage::className(), ['id' => 'lang_id']);
    }
	
	/**
     * @return \yii\db\ActiveQuery
     */
	public function getLayout()
	{
		return $this->hasOne(BlogHdbkLayout::className(), ['id' => 'layout_id']);
	}
	
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBlogMapPostCategories()
    {
        return $this->hasMany(BlogMapPostCategory::className(), ['category_id' => 'id']);
    }
	
	/**
     * @return \yii\db\ActiveQuery
     */
    public function getParent()
    {
        return $this->hasOne(BlogCategory::className(), ['id' => 'parent_category_id']);
    }
	
	/**
     * @return \yii\db\ActiveQuery
     */
    public function getGroup()
    {
        return $this->hasOne(BlogGroup::className(), ['id' => 'group_id']);
    }
	
	public function getStatus()
	{
		return $this->hasOne(BlogHdbkStatus::className(), ['id' => 'status_id']);
	}

	public function getTranslationTemplate($langId)
	{
		$target = new self();
		$target->lang_id = $langId;
		$target->alias = $this->alias;

		foreach (self::TRANS_FIELDS as $field){
			$target->{$field}  = $this->{$field};
		}

		$target->setParentCategory($this);

		$target->parentSave();
		
		return $target;
	}

	
	public static function getParentName()
	{
		return self::find()
			->select(['id', 'name'])
			->where(['lang_id' => Yii::$app->params['settings']['defaultLangObj']['id']])
			->orderBy('name')
			->all();
	}
	
	public static function getCategoriesByGroup($group_id)
	{
		return self::find()
			->where(['group_id' => $group_id, 'status_id' => 11])
			->all();
	}
	
	public static function getParentLangName($id)
	{
		return self::find()
			->select(['id', 'name'])
			->where(['lang_id' => $id])
            ->orderBy('name')
			->all();
	}
	
	public static function getParentSearch()
	{
		$cats = self::find()->all();
		
		$res = [];
				
		foreach ($cats as $cat){
			if ($cat->parent_category_id > 0){
				$res[$cat->parent_category_id] = $cat->parent->name;
			}				
		}
		
		return $res;
	}
	
	public static function getFilteredLinks($alias)
	{
		return self::find()
				->where([
					'blog_category.alias' => $alias,
					'blog_category.lang_id' => HdbkLanguage::getLanguageByCode(Yii::$app->language)
				])
				->orderBy('name')
				->all();
	}
	
	public function saveUpdatedCaregory()
	{
		if (!empty(Yii::$app->request->post())){
			$request = Yii::$app->request->post();
		}
		$parentId = 1;
		$postSource = BlogCategory::find()
				->select('lang_id')
				->where(['id' => $this->id])
				->scalar();
		$sourceLangCode = HdbkLanguage::getLanguageById($postSource)->code;
		$translationSource = BlogMapEntityLang::getTranslationCatRow($this->id, $sourceLangCode);
		$translationSource->{$sourceLangCode} = NULL;
		
		if(!empty($this->parent->parent)){
			$parentId = $this->parent->parent->parent_category_id;
		}
		
		if($translationSource->alias !== $request['BlogCategory']['alias'] && $parentId === 0 && empty(self::getChildrenCats($this->id))){
			$lang = HdbkLanguage::getLanguageById($request['BlogCategory']['lang_id'])['code'];
			$oldUrl = Url::to(['/blog/category/front-view', 'id' => $this->id]);
			$position = strripos($oldUrl, '/') + 1;
			$url = substr($oldUrl, 0, $position);
			$newUrl = $url.$request['BlogCategory']['alias'];
			if($lang !== Yii::$app->params['settings']['defaultLanguage']){
				$oldUrl = substr($oldUrl, 3);
				$newUrl = substr($newUrl, 3);
			}
			$redirect = new Redirects;
			$redirect->old_url = $oldUrl;
			$redirect->new_url = $newUrl;
			$redirect->save();
		}
		$translationSource->save();
		$this->save();
		$this->saveAliasCatChain();

		return $this->save() && $this->saveAliasCatChain();
	}
	
	public function save($runValidation = true, $attributeNames = NULL){
		return parent::save($runValidation = true, $attributeNames = NULL) && $this->saveCatLangChain();
	}
	
	public function saveCatLangChain(){
		$translation = BlogMapEntityLang::getTranslationCatRow($this->id, $this->lang->code);
		
		$translation_re = $translation;
		
		if (!empty(Yii::$app->request->post())){
			$request = Yii::$app->request->post();
		}
		
		$translationRowIdInt = (!empty($request['BlogMapEntityLang']['id'])) ? $request['BlogMapEntityLang']['id'] : 0;

		if(empty($translation) && ($translationRowIdInt !== 0)){
			$translation = BlogMapEntityLang::findOne($translationRowIdInt);
			$languages = HdbkLanguage::getLanguageById($request["BlogCategory"]['lang_id']);

			if(empty(Yii::$app->request->get()['translate_to'])){
				$translation->{$languages->code} = $this->id;
			}else{
				$translation->{$this->lang->code} = $this->id;
			}
		}elseif (empty ($translation)){
			$translation = new BlogMapEntityLang();
			$translation->{$this->lang->code} = $this->id;
		}
		
		if (!empty($request['BlogCategory']['alias'])){
			$translation->alias = $request['BlogCategory']['alias'];
		}
		
		$translation->entity_type_id = 2;
		if ($translation->save()){
			return true;
		}else{
			return false;
		}
	}	

	public function saveAliasCatChain()
	{
		$postSource = BlogCategory::find()
				->select('lang_id')
				->where(['id' => $this->id])
				->scalar();
		$sourceLangCode = HdbkLanguage::getLanguageById($postSource)->code;
		$translationSource = BlogMapEntityLang::getTranslationCatRow($this->id, $sourceLangCode);
		$lang_array = Yii::$app->params['settings']['supportedLanguages'];

		$postId = [];
		foreach ($lang_array as $key => $val){
			if(!empty($translationSource->$val)){
				array_push($postId, $translationSource->$val);
			}
		}

		$chainAlias = Yii::$app->request->post()['BlogCategory']['alias'];
		$getBlogPosts = self::find()
				->where(['id' => $postId])
				->all();

		foreach ($getBlogPosts as $getBlogPost){
			$getBlogPost->alias = $chainAlias;
			$getBlogPost->save();
		}	
		if ($getBlogPost->save()){
			return true;
		}else{
			return false;
		}
	}
	
	public function setParentCategory($source)
	{
		$parentCat = BlogCategory::findOne([
			'lang_id' => $this->lang_id,
			'alias' => $source->parent->alias
		]);

		if (is_object($parentCat)){
			$this->parent_category_id = $parentCat->id;
		} else {
			$parentCat = BlogCategory::findOne([
				'lang_id' => $source['lang_id'],
				'alias'	=> 'root'
			]);
			$this->parent_category_id = $parentCat->id;
		}
	}
	
	
	/**
	 * Just parent saving...
	 * 
	 * @return bool whether the saving succeeded (i.e. no validation errors occurred).
	 */
	public function parentSave(){
		return parent::save();
	}

	public function delete(){
		return parent::delete() && $this->deleteEntityChain(); 
	}
	
	public function deleteEntityChain()
	{
		$lang_array = Yii::$app->params['settings']['supportedLanguages'];
		$deleteEntityChain = BlogMapEntityLang::getTranslationCatRow($this->id, $this->lang->code);
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
	
	public static function getChildrenCats($catId)
	{
		return self::find()
			->where(['parent_category_id' => $catId])
			->all();
	}
	
	public static function getRootCats()
	{
		return self::find()
			->where(['parent_category_id' => 0])
			->all();
	}
	
	public static function getThumbnails($alias, $lang)
	{
		return self::find()
			->where(['alias' => $alias, 'lang_id' => $lang, 'status_id' => 11])
			->one();
	}
	
	public static function getRootCatsIds()
	{
		return self::find()
			->where(['parent_category_id' => 0])
			->column();
	}
	
    public static function getCategory($id)
	{
		$db = Yii::$app->db;
		return $db->cache(function ($db) use ($id) {
			
			return self::find()
				->where(['id' => $id])
				->orderBy('name')
				->all();
		}, 3600);
	}
	
	public static function getCategoryById($id)
	{
		$db = Yii::$app->db;
		return $db->cache(function ($db) use ($id) {
			
			return self::findOne($id);
		}, 3600);
	}
        
	/**
	 * Finds the nearest to the language_root_cat parent of the category with
	 * id = catId
	 * 
	 * @param integer $catId
	 * @return frontend/module/blog/models/BlogCategory
	 */
	public static function getSubRootCat($catId)
	{
		do {
			$cat = self::findOne($catId);
			$catId = $cat->parent_category_id;
		} while ($cat->parent->parent_category_id !== 0);
		
		return $cat;
	}
	
	public static function getListCategoryByCode($id)
	{
		return self::find()
                ->where(['lang_id' => $id])
                ->orderBy('name')
                ->all();
	}
	
	public function hasSubitems()
	{
		$subCats = self::getChildrenCats($this->id);
		
		if (!empty($subCats)){
			return TRUE;
		} else {
			$posts = BlogPost::findAll(['main_category_id' => $this->id]);
			if (!empty($posts)){
				return TRUE;
			}
		}
		
		return FALSE;
	}
	
	/**
	 * Checks if some new html tags were added to content
	 * 
	 * @param integer $sourceCatId
	 * @param array $allowedTags Array of tag, that are allowed for adding by translator
	 * @return array
	 */
	public function validateContent($sourceCatId = 0, $allowedTags = ['br', 'p'])
	{
		if ($sourceCatId > 0){
			$sourceCat = self::findOne($sourceCatId);
		} else {
			$sourceCat = self::findOne($this->id);
		}		
		
		$sourceTags = Functions::countElements($sourceCat->content);
		$targetTags = Functions::countElements($this->content);
		
		foreach ($targetTags as $tag => $count){
			if (in_array($tag, $allowedTags)){
				unset($targetTags[$tag]);
			} elseif ($sourceTags[$tag] == $count){
				unset($targetTags[$tag]);
			}
		}
		
		if (sizeof($targetTags) > 0){
			return [
				'status' => FALSE,
				'message' => Yii::t('blob', 'HTML_TAGS_NOT_ALLOWED')
			];
		} else {
			return ['status' => TRUE];
		}
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
	
	public static function getBlogAliases()
	{
		return self::find()
			->select(['alias'])
			->where([
					'layout_id' => 2,
				])
			->distinct()
			->column();
	}
	
	public function getTranslatedCategory($old_model, $translate_to)
	{
		$translatedRow = BlogMapEntityLang::getTranslationCatRow($old_model->parent_category_id, HdbkLanguage::getLanguageById($old_model->lang_id)->code);
		
		$categories =  self::find()
				->select(['id','name'])
				->where(['lang_id' => HdbkLanguage::getLanguageByCode($translate_to)])
				->orderBy('name')
				->all();
		
		$categoriesArray = ArrayHelper::map($categories,'id','name');
		
		if(!empty($translatedRow[$translate_to])){
			$translationCategory = self::getCategory($translatedRow[$translate_to]);
			unset($categoriesArray[$translationCategory[0]->id]);
			$translationCategoryArray = [$translationCategory[0]['id'] => $translationCategory[0]['name']];
			$categoriesArray = $translationCategoryArray + $categoriesArray;
		}

		return $categoriesArray;
	}
	
	public function getTranslationCatFlag($old_model, $translate_to)
	{
		$translatedRow = BlogMapEntityLang::getTranslationCatRow($old_model->parent_category_id, HdbkLanguage::getLanguageById($old_model->lang_id)->code);
		
		$flag = FALSE;
		
		if(!empty($translatedRow[$translate_to])){
			$flag = TRUE;
		}
		
		return $flag;
	}
	
	public function getHookFromContent()
	{
		if(strstr($this->content, '[displaying')) {
			$result = strstr($this->content, '[displaying');
			$hook = substr($result, 0, stripos($result,']')+1);
			return $hook;
		}
		else {
			return false;
		}
	}
	
	public function addHookID($id, $hook) {
		$replacehook = '[displaying hook=';
		$items = $this->getPostsID($hook);
		for($index=0; $index<count($items); ++$index) {
			$replacehook .= $items[$index].',';
		}
		$replacehook .= $id.']';
		return $replacehook;
	}
	
	public function getPostsID($hookstring)
	{
		$result = substr($hookstring, (stripos($hookstring,'='))+1);
		$result = substr($result, 0, stripos($result,']'));
		$postsId = str_getcsv($result, ',');
		return $postsId;
	}
	
	public static function getCategoryByAlias($alias)
	{
		return self::find()
				->where([
					'lang_id' => HdbkLanguage::getLanguageByCode(Yii::$app->language),
					'alias' => $alias
				])
				->one();
	}
	
	public static function updateHook($id, $hook) {
		$category = self::findOne($id);
		$category->shortcodes = $hook;
		$category->save();
	}
}
