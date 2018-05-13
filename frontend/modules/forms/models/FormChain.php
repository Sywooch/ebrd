<?php

namespace frontend\modules\forms\models;

use yii\helpers\Json;
use Yii;

/**
 * This is the model class for table "form_chain".
 *
 * @property integer $id
 * @property string $name
 * @property string $title
 * @property string $description
 * @property string $steps
 * @property string $answer
 * @property string $created_at
 * @property string $updated_at
 */
class FormChain extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'form_chain';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['description', 'steps', 'answer'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['name', 'title'], 'string', 'max' => 255],
            [['name'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('forms', 'ID'),
            'name' => Yii::t('forms', 'Name'),
            'title' => Yii::t('forms', 'Title'),
            'description' => Yii::t('forms', 'Description'),
            'steps' => Yii::t('forms', 'Steps'),
            'created_at' => Yii::t('forms', 'Created At'),
            'updated_at' => Yii::t('forms', 'Updated At'),
        ];
    }
	
	public static function getChainIdByName($name)
	{
		$chain = self::findOne(['name' => $name]);
		if (is_object($chain)){
			return $chain->id;
		} else {
			return FALSE;
		}
	}
	
	public static function getFormId($chainId, $chainStep)
	{
		$chain = self::findOne($chainId);
		if (is_object($chain)){
			return Json::decode($chain->steps)[$chainStep];
		}
		
		return FALSE;
	}
	
	public static function getFormChainById()
	{
		return self::find()->select(['steps'])->all();
	}
}
