<?php

namespace frontend\modules\letter\models;

use frontend\modules\blog\models\BlogMapEntityLang;
use Yii;
use frontend\models\HdbkLanguage;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "letter".
 *
 * @property integer $id
 * @property string $name
 * @property string $content
 * @property integer $lang_id
 * @property string $created_at
 * @property string $updated_at
 */
class Letter extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'letter';
    }

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
    public function rules()
    {
        return [
            [['name', 'content', 'lang_id', 'title'], 'required'],
            [['content'], 'string'],
            ['content', 'checkKeywords'],
            [['title'], 'string'],
            [['keywords'], 'string'],
            [['lang_id'], 'integer'],
            [
                ['lang_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => HdbkLanguage::className(),
                'targetAttribute' => ['lang_id' => 'id']
            ],
            [['created_at', 'updated_at'], 'safe'],
            [['name','title'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'title' => 'Title',
            'keywords' => 'Keywords',
            'content' => 'Content',
            'lang_id' => 'Lang',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLang()
    {
        return $this->hasOne(HdbkLanguage::className(), ['id' => 'lang_id']);
    }

    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);
        if (!$insert) return true;

        $request = Yii::$app->request->get();
        $oldModel = isset($request['translated_id']) ? Letter::findOne($request['translated_id']) : null;
        $translation = $oldModel ? BlogMapEntityLang::getTranslationLetterRow($oldModel->id, $oldModel->lang->code) : null;
        if (!$translation || $oldModel->lang->code == $this->lang->code) {
            $translation = new BlogMapEntityLang();
            $translation->entity_type_id = 4;
        }

        $translation->{$this->lang->code} = $this->id;

        return $translation->save();
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            $languages = HdbkLanguage::getLanguagesSymbols();
            $items = ArrayHelper::map($languages, 'id', 'code');
            $translation = $this->id ? BlogMapEntityLang::getTranslationLetterRow($this->id, $this->lang->code) : null;
            if ($translation) {
                $translation->{$this->lang->code} = null;
                $translation->{$items[$this->lang_id]} = $this->id;
                return $translation->save();
            }

            return true;
        }

        return false;
    }

    public function beforeDelete()
    {
        if (!parent::beforeDelete()) {
            return false;
        }

        $languages = HdbkLanguage::getLanguagesSymbols();
        $items = ArrayHelper::map($languages, 'id', 'code');
        $languages = ArrayHelper::map($languages, 'code', 'id');
        $code = $items[$this->lang_id];
        $translation = BlogMapEntityLang::getTranslationLetterRow($this->id, $code);
        $translation[$code] = null;

        foreach ($translation as $key => $item) {
            if (!isset($languages[$key]) || is_null($item)) continue;
            return $translation->save();
        }

        return $translation->delete();
    }

    public static function formatLangCode($code, $langList)
    {
        foreach ($langList as $lang) {
            if ($code == $lang['code']) {
                return [$lang['id'] => $lang['name']];
            }
        }

        return false;
    }

    public function checkKeywords($attribute, $params)
    {
        $keywords = array_map('trim', explode(',', $this->keywords));
        foreach ($keywords as $keyword) {
            if (!preg_match('/{{'. $keyword .'}}/ui', $this->content)) {
                $this->addError($attribute, 'All keywords must be in the content');
            }
        }
    }
}
