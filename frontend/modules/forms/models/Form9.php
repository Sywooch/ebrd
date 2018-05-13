<?php

namespace frontend\modules\forms\models;

use Yii;

/**
 * This is the model class for table "form_9".
 *
 * @property integer $id
 * @property string $full_name
 * @property string $email
 * @property string $phone
 * @property string $company
 * @property string $referrer
 * @property string $submitted_at
 */
class Form9 extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'form_9';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['referrer'], 'string'],
            [['submitted_at'], 'safe'],
            [['full_name'], 'string', 'max' => 255],
            [['email', 'phone'], 'string', 'max' => 45],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('forms', 'ID'),
            'full_name' => Yii::t('forms', 'Full Name'),
            'email' => Yii::t('forms', 'Email'),
            'phone' => Yii::t('forms', 'Phone'),
            'referrer' => Yii::t('forms', 'Referrer'),
            'submitted_at' => Yii::t('forms', 'Submitted At'),
        ];
    }
}
