<?php

namespace frontend\modules\blog\models;

use Yii;
use frontend\modules\blog\models\BlogCategory;

/**
 * This is the model class for table "blog_stakeholder".
 *
 * @property int $id
 * @property string $name
 * @property string $logo
 * @property string $mail
 * @property string $phone
 * @property int $group_id
 * @property int $region_id
 * @property string $description
 */
class BlogStakeholder extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'blog_stakeholder';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'mail', 'phone', 'location', 'group_id'], 'required'],
            [['group_id'], 'integer'],
            [['description'], 'string'],
			[['location'], 'string', 'max' => 100],
            [['name'], 'string', 'max' => 150],
            [['logo', 'mail'], 'string', 'max' => 50],
			[['phone'], 'string', 'max' => 20],
            [['phone'], 'match', 'pattern' => '/^[0-9]{10}$/', 'message' => Yii::t('blog', 'STAKEHOLDERS_PHONE_ENTERING_FORMAT')]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('blog', 'ID'),
            'name' => Yii::t('blog', 'STAKEHOLDER_NAME'),
            'logo' => Yii::t('blog', 'STAKEHOLDER_LOGO'),
            'mail' => Yii::t('blog', 'STAKEHOLDER_MAIL'),
            'phone' => Yii::t('blog', 'STAKEHOLDER_PHONE'),
            'group_id' => Yii::t('blog', 'STAKEHOLDER_GROUP'),
            'location' => Yii::t('blog', 'STAKEHOLDER_LOCATION'),
            'description' => Yii::t('blog', 'STAKEHOLDER_DESCRIPTION'),
        ];
    }
	
	public function findByCategoryId($groupid)
	{
		return self::find()
			->select([
                'blog_stakeholder.mail',
				'blog_stakeholder.phone',
				'blog_stakeholder.id',
				'blog_stakeholder.name',
				'blog_stakeholder.location',
				'blog_stakeholder.group_id',
				'blog_stakeholder.description',
				'blog_stakeholder.logo',
			])	
			->where([
					'blog_stakeholder.group_id' => $groupid,
			]);
	}
	
	public function getCategoryName($catid)
	{
		$cat = BlogCategory::find()->select('name')->where(['id' => $catid])->asArray()->one();
		return $cat['name'];
	}
}
