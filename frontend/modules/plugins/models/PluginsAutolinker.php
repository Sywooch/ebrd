<?php

namespace frontend\modules\plugins\models;

use Yii;

/**
 * This is the model class for table "plugins__autolinker".
 *
 * @property integer $id
 * @property string $title
 * @property string $keywords
 * @property string $url
 * @property integer $links_quantity
 * @property string $target
 * @property string $lang
 * @property string $created_at
 * @property string $updated_at
 * @property string $info
 */
class PluginsAutolinker extends \yii\db\ActiveRecord
{
    const STATUS_ENABLED = 1;
    const STATUS_DISABLED= 0;

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
        return 'plugins__autolinker';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
			[['links_quantity', 'title', 'keywords', 'url', 'lang', 'status'], 'required'],
            [['keywords', 'info'], 'string'],
            [['links_quantity', 'status'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['title'], 'string', 'max' => 190],
            [['url', 'target', 'lang'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('plugins', 'ID'),
            'title' => Yii::t('plugins', 'Title'),
            'keywords' => Yii::t('plugins', 'Keywords'),
            'url' => Yii::t('plugins', 'Url'),
            'links_quantity' => Yii::t('plugins', 'Links Quantity'),
            'target' => Yii::t('plugins', 'Target'),
            'lang' => Yii::t('plugins', 'Lang'),
            'created_at' => Yii::t('plugins', 'Created At'),
            'updated_at' => Yii::t('plugins', 'Updated At'),
            'info' => Yii::t('plugins', 'Info'),
            'status' => Yii::t('plugins', 'Status'),
        ];
    }

    /**
     * Before update or create sorts keywords by its length
     * @param type $insert
     * @return boolean
     */
    public function beforeSave($insert)
    {
        if (!parent::beforeSave($insert)) {
            return false;
        }
        
        $rowKeys = array_map('trim', explode(',', $this->keywords));
        usort($rowKeys, array(self::className(), 'sort'));
        $this->keywords = implode(", ", $rowKeys);
        return true;
    }
    
    /**
     * Sorts values by its length
     * @param type $a
     * @param type $b
     * @return type
     */
    private static function sort($a, $b) {
       return strlen($b) - strlen($a);
    }
    
    /**
     * Changes status on broken links
     * @param $id
     * @param $status
     * @param null $info
     */
    public static function changeStatus($id, $status, $info = null)
    {
        $model = self::findOne($id);

        $model->status = $status;
        $model->info .= $info;
        $model->save();
    }
    
    /**
     * Changes links if they was moved
     * @param $id
     * @param $status
     * @param null $info
     */
    public static function changeLink($id, $link, $info = null)
    {
        $model = self::findOne($id);

        $model->url = $link;
        $model->info .= $info;
        $model->save();
    }
	
//	public static function getAutolinkerRows()
//    {
//		$db = Yii::$app->db;
//		return $db->cache(function ($db) {
//			
//			return self::find()
//					->where(['lang' => Yii::$app->language])
//					->andWhere(['status' => PluginsAutolinker::STATUS_ENABLED])
//					->all();
//		}, 3600);
//    }
	
	public static function getAutolinkerRows()
    {
		return self::find()
			->where(['lang' => Yii::$app->language])
			->andWhere(['status' => PluginsAutolinker::STATUS_ENABLED])
			->all();
    }
	
//	public static function getAutolinkerRows()
//    {
//		$db = Yii::$app->db;
//		return $db->cache(function ($db) {
//			
//			return self::find()
//					->where(['lang' => Yii::$app->language])
//					->andWhere(['status' => PluginsAutolinker::STATUS_ENABLED])
//					->all();
//		}, 3600);
//    }
}
