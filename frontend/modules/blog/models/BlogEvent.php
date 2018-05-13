<?php

namespace frontend\modules\blog\models;

use common\models\User;
use frontend\models\HdbkLanguage;
use Yii;
use yii\db\Expression;

/**
 * This is the model class for table "blog_event".
 *
 * @property int $id
 * @property int $stakeholder_id
 * @property int $lang_id
 * @property string $alias
 * @property string $title
 * @property string $description
 * @property string $site_url
 * @property string $place
 * @property string $city
 * @property string $name
 * @property string $date_begin
 * @property string $date_end
 * @property string $picture
 * @property BlogStakeholder $stakeholder
 * @property HdbkLanguage $lang
 * @property BlogMapEventUser[] $blogMapEventUsers
 * @property User[] $users
 * @property BlogEventStatus $status
 */
class BlogEvent extends \yii\db\ActiveRecord
{
    public $date;
    public $status;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'blog_event';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['stakeholder_id', 'lang_id'], 'required'],
            [['stakeholder_id', 'lang_id'], 'integer'],
            [['description'], 'string'],
            [['date_begin', 'date_end'], 'safe'],
            [
                'alias',
                'match',
                'pattern' => '/^[a-z0-9-]+$/',
                'message' => Yii::t('blog', 'YOU CAN USE ONLY LOWER CASE, NUMBERS AND "-"')
            ],
            [['title', 'site_url', 'place', 'name'], 'string', 'max' => 255],
            [['picture','city'], 'string', 'max' => 100],
            [['stakeholder_id'], 'exist', 'skipOnError' => true, 'targetClass' => BlogStakeholder::className(), 'targetAttribute' => ['stakeholder_id' => 'id']],
            [['lang_id'], 'exist', 'skipOnError' => true, 'targetClass' => HdbkLanguage ::className(), 'targetAttribute' => ['lang_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'stakeholder_id' => 'Stakeholder ID',
            'lang_id' => 'Lang ID',
            'alias' => 'Alias',
            'title' => 'Title',
            'description' => 'Description',
            'site_url' => 'Site Url',
            'place' => 'Place',
            'city' => 'City',
            'name' => 'Name',
            'date_begin' => 'Date Begin',
            'date_end' => 'Date End',
            'picture' => 'Picture',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStakeholder()
    {
        return $this->hasOne(BlogStakeholder::className(), ['id' => 'stakeholder_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLang()
    {
        return $this->hasOne(HdbkLanguage::className(), ['id' => 'lang_id']);
    }

    public function getStatus()
    {
        return $this
            ->hasOne(BlogEventStatus::className(), ['id' => 'status'])
            ->viaTable('blog_map_event_user', ['event_id' => 'id'])
            ->one();
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBlogMapEventUsers()
    {
        return $this->hasMany(BlogMapEventUser::className(), ['event_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasMany(User::className(), ['id' => 'user_id'])->viaTable('blog_map_event_user', ['event_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function addUser($id)
    {

        return $this->hasMany(User::className(), ['id' => 'user_id'])->viaTable('blog_map_event_user', ['event_id' => 'id']);
    }

    public static function findBlogEvents($filterDate)
    {
        $events = self::find()
            ->select([
                'blog_event.picture',
                'blog_event.id',
                'blog_event.name',
                'blog_event.title',
                'blog_event.city',
                'blog_event.place',
                'blog_event.date_begin',
                'blog_event.date_end',
            ])
            ->where([
                'blog_event.lang_id' => HdbkLanguage::getLanguageByCode(Yii::$app->language),
            ])
            ->orderBy(['date_begin' => SORT_DESC]);

            if($filterDate == 'past'){
                $events->andWhere(['<', 'date_end', new Expression('NOW()')] );
            }else{
                $events->andWhere(['>', 'date_end', new Expression('NOW()')] );
            }


        return $events;
    }

    public static function getEventById($id)
    {
        $db = Yii::$app->db;
        return $db->cache(function ($db) use ($id) {
            return self::findOne($id);
        }, 10);
    }

    public static function getEventByAlias($alias)
    {
        $lang = \Yii::$app->language;
        $db = Yii::$app->db;
        return $db->cache(function ($db) use ($alias) {
            return self::findOne([
                'alias' => $alias,
                'lang_id' => HdbkLanguage::getLanguageByCode(Yii::$app->language)
                ]);
        }, 10);
    }

    public static function getEventsByUser($userId)
    {
        return self::find()
            ->select([
                'blog_event.id',
                'blog_event.title',
                'blog_event.date_begin',
                'blog_event.date_end',
                'blog_event_status.name AS status_name'
            ])
            ->join('INNER JOIN','blog_map_event_user','event_id = id')
            ->join('LEFT JOIN','blog_event_status','blog_event_status.id = blog_map_event_user.status')
            ->where(['user_id' => $userId])
            ->asArray()
            ->all();
    }

    public static function getBlogEventsSlider()
    {
        return self::find()
            ->select([
                'blog_event.picture',
                'blog_event.id',
                'blog_event.name',
                'blog_event.title',
                'blog_event.place',
                'blog_event.city',
                'blog_event.date_begin',
                'blog_event.date_end',
            ])
            ->where([
                'blog_event.lang_id' => HdbkLanguage::getLanguageByCode(Yii::$app->language),
            ])
            ->limit(12)
            ->all();
    }
}
