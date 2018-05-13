<?php

namespace frontend\modules\forms\models;

use Yii;

/**
 * This is the model class for table "form_2".
 *
 * @property integer $id
 * @property string $email
 * @property string $referrer
 * @property string $submited_at
 */
class Form2 extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'form_2';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['email'], 'required'],
            [['referrer'], 'string'],
            [['submited_at'], 'safe'],
            [['email'], 'string', 'max' => 45],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('forms', 'ID'),
            'email' => Yii::t('forms', 'Email'),
            'referrer' => Yii::t('forms', 'Referrer'),
            'submited_at' => Yii::t('forms', 'Submited At'),
        ];
    }
}
