<?php

namespace frontend\modules\blog\models;

use frontend\components\Functions;
use frontend\modules\blog\interfaces\Publishable;
use frontend\modules\blog\models\BlogMapEntityLang;
use frontend\models\HdbkLanguage;
use yii\helpers\ArrayHelper;
use common\models\User;
use Yii;

/**
 * This is the model class for table "blog_post".
 *
 * @property integer $id
 * @property string $alias
 * @property string $name
 * @property integer $lang_id
 * @property integer $main_category_id
 * @property string $content
 * @property string $description
 * @property integer $published
 * @property integer $author_id
 * @property string $created_at
 * @property string $updated_at
 * @property integer $favorites
 *
 * @property BlogMapPostCategory[] $blogMapPostCategories
 * @property BlogMapPostTag[] $blogMapPostTags
 * @property HdbkLanguage $lang
 */
class BlogPost extends \yii\db\ActiveRecord implements Publishable
{
	const TRANS_FIELDS = [
		'name',
		'menu_section',
		'title',
		'description',
		'content'
	];
	
	public $type;
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
        return 'blog_post';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'lang_id', 'main_category_id','alias', 'menu_section', 'title'], 'required'],
            [['lang_id', 'thumbnail', 'main_category_id', 'author_id', 'favorites','show_author','time_to_read'], 'integer'],
            [['content', 'description', 'excerpt', 'published_at'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
			[
				'alias', 
				'match', 
				'pattern' => '/^[a-z0-9-]+$/', 
				'message' => Yii::t('blog', 'YOU CAN USE ONLY LOWER CASE, NUMBERS AND "-"')
			],
            [['alias', 'name', 'thumb_alt'], 'string', 'max' => 255],
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
            'lang_id' => Yii::t('blog', 'LANGUAGE'),
            'main_category_id' => Yii::t('blog', 'MAIN_CATEGORY'),
            'content' => Yii::t('blog', 'CONTENT'),
            'description' => Yii::t('blog', 'DESCRIPTION'),
            'author_id' => Yii::t('blog', 'AUTHOR'),
            'created_at' => Yii::t('blog', 'CREATED_AT'),
            'updated_at' => Yii::t('blog', 'UPDATED_AT'),
            'favorites' => Yii::t('blog', 'FAVORITES'),
			'thumbnail' => Yii::t('blog', 'THUMBNAIL'),
			'excerpt' => Yii::t('blog', 'EXCERPT'),
			'published_at' => Yii::t('blog', 'PUBLISHED_AT'),
			'show_author' => Yii::t('blog', 'SHOW_AUTHOR'),
			'time_to_read' => Yii::t('blog', 'TIME_TO_READ'),
			'thumb_alt' => Yii::t('blog', 'THUMBNAIL_ALT'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBlogMapPostCategories()
    {
        return $this->hasMany(BlogMapPostCategory::className(), ['post_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBlogMapPostTags()
    {
        return $this->hasMany(BlogMapPostTag::className(), ['post_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLang()
    {
        return $this->hasOne(HdbkLanguage::className(), ['id' => 'lang_id']);
    }
	
	public function getCategory()
    {
        return $this->hasOne(BlogCategory::className(), ['id' => 'main_category_id']);
    }
	
	public function getStatus()
	{
		return $this->hasOne(BlogHdbkStatus::className(), ['id' => 'status_id']);
	}
	
	public function getAuthor()
	{
		return $this->hasOne(User::className(), ['id' => 'author_id']);
	}

	public static function getParentName()
	{
		return self::find()
			->select(['id', 'name'])
			->all();
	}
	
	public static function getParentLangName($id)
	{
		return self::find()
			->select(['id', 'code' ,'name'])
			->where(['lang_id' => $id])
			->all();
	}
	
	public static function getParentSearch()
	{
		$cats = self::find()->all();
		
		$res = [];
				
		foreach ($cats as $cat){
			$res[$cat->main_category_id] = $cat->category->name;
		}
		
		return $res;
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
	
	public function saveUpdatedPost(){
		$postSource = BlogPost::find()
				->select('lang_id')
				->where(['id' => $this->id])
				->scalar();
		$sourceLangCode = HdbkLanguage::getLanguageById($postSource)->code;
		$translationSource = BlogMapEntityLang::getTranslationRow($this->id, $sourceLangCode);
		$translationSource->{$sourceLangCode} = NULL;
		$translationSource->save();
		$this->save();
		$this->saveAliasChain();
		return $this->save() && $this->saveAliasChain();
	}

	public function save($runValidation = true, $attributeNames = NULL){
		return parent::save($runValidation = true, $attributeNames = NULL) && $this->savePostLangChain(); 
	}
	
	public function savePostLangChain(){
		$translation = BlogMapEntityLang::getTranslationRow($this->id, $this->lang->code);
		
		if (!empty(Yii::$app->request->post())){
			$request = Yii::$app->request->post();
		}
		
		$translationRowIdInt = (!empty($request['BlogMapEntityLang']['id'])) ? $request['BlogMapEntityLang']['id'] : 0;
		
		if(empty($translation) && ($translationRowIdInt !== 0)){
			$translation = BlogMapEntityLang::findOne($translationRowIdInt);
			$languages = HdbkLanguage::getLanguageById($request["BlogPost"]['lang_id']);

			if(empty(Yii::$app->request->get()['translate_to'])){
				$translation->{$languages->code} = $this->id;
			}else{
				$translation->{$this->lang->code} = $this->id;
			}
		}elseif (empty ($translation)){
			$translation = new BlogMapEntityLang();
			$translation->{$this->lang->code} = $this->id;
		}
		if (!empty($request['BlogPost']['alias'])){
			$translation->alias = $request['BlogPost']['alias'];
		}
		$translation->entity_type_id = 1;
		if ($translation->save()){
			return true;
		}else{
			return false;
		}
	}
	
	public function saveAliasChain()
	{
		$postSource = BlogPost::find()
				->select('lang_id')
				->where(['id' => $this->id])
				->scalar();
		$sourceLangCode = HdbkLanguage::getLanguageById($postSource)->code;
		$translationSource = BlogMapEntityLang::getTranslationRow($this->id, $sourceLangCode);
		$lang_array = Yii::$app->params['settings']['supportedLanguages'];

		$postId = [];
		foreach ($lang_array as $key => $val){
			if(!empty($translationSource->$val)){
				array_push($postId, $translationSource->$val);
			}
		}
		$chainAlias = Yii::$app->request->post()['BlogPost']['alias'];
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
			'alias' => $source->category->alias
		]);

		if (is_object($parentCat)){
			$this->main_category_id = $parentCat->id;
		} else {
			$parentCat = BlogCategory::findOne([
				'lang_id' => $source['lang_id'],
				'alias'	=> 'root'
			]);
			$this->main_category_id = $parentCat->id;
		}
	}
	
	/**
	 * Checks if some new html tags were added to content
	 * 
	 * @param integer $sourcePostId
	 * @param array $allowedTags Array of tag, that are allowed for adding by translator
	 * @return array
	 */
	public function validateContent($sourcePostId = 0, $allowedTags = ['br', 'p'])
	{
		if ($sourcePostId > 0){
			$sourcePost = self::findOne($sourcePostId);
		} else {
			$sourcePost = self::findOne($this->id);
		}		
		
		$sourceTags = Functions::countElements($sourcePost->content);
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
	
	public function delete(){
		return parent::delete() && $this->deleteEntityChain(); 
	}
	
	public function deleteEntityChain()
	{
		$lang_array = Yii::$app->params['settings']['supportedLanguages'];
		$deleteEntityChain = BlogMapEntityLang::getTranslationRow($this->id, $this->lang->code);
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
	
	public static function findBlogPosts($alias)
	{
		return self::find()
			->select([
                'blog_post.content',
				'blog_post.thumbnail',
				'blog_post.id',
				'blog_post.name',
				'blog_post.excerpt',
				'blog_post.author_id',
				'blog_post.main_category_id',
				'IF (blog_post.published_at = "" OR isnull(blog_post.published_at), blog_post.created_at, blog_post.published_at) AS published_at'
			])	
			->where([
					'blog_category.alias' => $alias,
					'blog_category.lang_id' => HdbkLanguage::getLanguageByCode(Yii::$app->language),
					'blog_post.status_id' => BlogPost::STATUS_PUBLISHED,
			])
			->orderBy(['published_at' => SORT_DESC])
			->joinWith('category');
	}
	
	public function getRelatedBlogPostsById($catId, $postId)
	{
		return self::find()
			->select([
                'blog_post.content',
				'blog_post.thumbnail',
				'blog_post.id',
				'blog_post.author_id',
				'blog_post.name',
				'blog_post.excerpt',
				'blog_post.main_category_id',
				'IF (blog_post.published_at = "" OR isnull(blog_post.published_at), blog_post.created_at, blog_post.published_at) AS published_at'
			])	
			->where(['blog_post.main_category_id' => $catId, 'blog_post.status_id' => self::STATUS_PUBLISHED])
			->andWhere(['!=', 'blog_post.id', $postId])
			->orderBy(['published_at' => SORT_DESC])
			->joinWith('category')
			->limit(12)
			->all();
	}
	
	public static function getBlogPostsSlider($blogAliases)
	{
		return self::find()
			->select([
                'blog_post.content',
				'blog_post.thumbnail',
				'blog_post.id',
				'blog_post.author_id',
				'blog_post.name',
				'blog_post.excerpt',
				'blog_post.main_category_id',
				'IF (blog_post.published_at = "" OR isnull(blog_post.published_at), blog_post.created_at, blog_post.published_at) AS published_at'
			])	
			->where([
					'blog_category.alias' => $blogAliases,
					'blog_category.lang_id' => HdbkLanguage::getLanguageByCode(Yii::$app->language),
					'blog_post.status_id' => BlogPost::STATUS_PUBLISHED,
			])
			->orderBy(['published_at' => SORT_DESC])
			->joinWith('category')
			->limit(12)
			->all();
	}
	
	public function getTranslatedCategory($old_model, $translate_to)
	{
		$translatedRow = BlogMapEntityLang::getTranslationCatRow($old_model->main_category_id, HdbkLanguage::getLanguageById($old_model->lang_id)->code);
		
		$categories = BlogCategory::find()
				->select(['id','name'])
				->where(['lang_id' => HdbkLanguage::getLanguageByCode($translate_to)])
				->orderBy('name')
				->all();
		
		$categoriesArray = ArrayHelper::map($categories,'id','name');
		
		if(!empty($translatedRow[$translate_to])){
			$translationCategory = BlogCategory::getCategory($translatedRow[$translate_to]);
			unset($categoriesArray[$translationCategory[0]->id]);
			$translationCategoryArray = [$translationCategory[0]['id'] => $translationCategory[0]['name']];
			$categoriesArray = $translationCategoryArray + $categoriesArray;
		}

		return $categoriesArray;
	}
	
	public function getTranslationCatFlag($old_model, $translate_to)
	{
		$translatedRow = BlogMapEntityLang::getTranslationCatRow($old_model->main_category_id, HdbkLanguage::getLanguageById($old_model->lang_id)->code);
		
		$flag = FALSE;
		
		if(!empty($translatedRow[$translate_to])){
			$flag = TRUE;
		}
		
		return $flag;
	}
	
	public static function getPostById($id)
	{
		$db = Yii::$app->db;
		return $db->cache(function ($db) use ($id) {
			
			return self::findOne($id);
		}, 10);
	}
	
}
