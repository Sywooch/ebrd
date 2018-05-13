<?php

namespace frontend\modules\forms\models;

use Yii;

/**
 * This is the model class for table "inquirer_1".
 *
 * @property int $id
 * @property string $answer
 */
class Inquirer1 extends \yii\db\ActiveRecord
{
	
	public $importance_1;
	public $realization_1;
	public $message_1;
	public $importance_2;
	public $realization_2;
	public $message_2;
	public $importance_3;
	public $realization_3;
	public $message_3;
	public $importance_4;
	public $realization_4;
	public $message_4;
	public $importance_5;
	public $realization_5;
	public $message_5;
	public $importance_6;
	public $realization_6;
	public $message_6;
	public $importance_7;
	public $realization_7;
	public $message_7;
	public $importance_8;
	public $realization_8;
	public $message_8;
	public $importance_9;
	public $realization_9;
	public $message_9;
	public $importance_10;
	public $realization_10;
	public $message_10;
	public $importance_11;
	public $realization_11;
	public $message_11;
	public $importance_12;
	public $realization_12;
	public $message_12;
	public $importance_13;
	public $realization_13;
	public $message_13;
	public $importance_14;
	public $realization_14;
	public $message_14;
	public $importance_15;
	public $realization_15;
	public $message_15;
	
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'inquirer_1';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['answer'], 'required'],
            [['answer'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('forms', 'ID'),
            'answer' => Yii::t('forms', 'Answer'),
        ];
    }
}
