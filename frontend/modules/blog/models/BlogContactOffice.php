<?php

namespace frontend\modules\blog\models;

use Yii;

/**
 * This is the model class for table "blog_contact_office".
 *
 * @property integer $id
 * @property string $alias
 * @property string $office_name
 * @property string $title
 * @property string $menu_section
 * @property string $content
 * @property string $office_country
 * @property string $office_address
 * @property string $email
 * @property string $phone
 * @property string $contact_ip
 * @property string $lang_name
 * @property string $created_at
 * @property string $updated_at
 */
class BlogContactOffice extends \yii\db\ActiveRecord
{
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
        return 'blog_contact_office';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['alias', 'office_name', 'menu_section', 'office_country', 'office_address', 'email', 'phone', 'lang_name'], 'required'],
            [['content'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['alias', 'office_name', 'title', 'menu_section', 'office_country', 'office_address', 'email', 'phone', 'contact_ip', 'lang_name'], 'string', 'max' => 255],
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
            'office_name' => Yii::t('blog', 'OFFICE NAME'),
            'title' => Yii::t('blog', 'TITLE'),
            'menu_section' => Yii::t('blog', 'MENU SECTION'),
            'content' => Yii::t('blog', 'LINK OFFICE MAP'),
            'office_country' => Yii::t('blog', 'OFFICE COUNTRY'),
            'office_address' => Yii::t('blog', 'OFFICE ADDRESS'),
            'email' => Yii::t('blog', 'EMAIL'),
            'phone' => Yii::t('blog', 'PHONE'),
            'contact_ip' => Yii::t('blog', 'CONTACT IP'),
            'lang_name' => Yii::t('blog', 'OFFICE LOCATION'),
            'created_at' => Yii::t('blog', 'CREATED AT'),
            'updated_at' => Yii::t('blog', 'UPDATED AT'),
			'lat' => Yii::t('blog', 'LAT'),
			'lng' => Yii::t('blog', 'LNG'),
        ];
    }
}
