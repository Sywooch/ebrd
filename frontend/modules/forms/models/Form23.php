<?php

namespace frontend\modules\forms\models;

use Yii;

/**
 * This is the model class for table "form_23".
 *
 * @property int $id
 * @property string $phone
 * @property string $email
 * @property string $referrer
 * @property string $submited_at
 */
class Form23 extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'form_23';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['phone', 'email'], 'required'],
            [['referrer'], 'string'],
            [['submited_at'], 'safe'],
            [['phone'], 'string', 'max' => 20],
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
            'phone' => Yii::t('forms', 'Phone'),
            'email' => Yii::t('forms', 'Email'),
            'referrer' => Yii::t('forms', 'Referrer'),
            'submited_at' => Yii::t('forms', 'Submited At'),
        ];
    }
}
