<?php

namespace frontend\modules\forms\models;

use Yii;

/**
 * This is the model class for table "form_1".
 *
 * @property integer $id
 * @property string $full_name
 * @property string $email
 * @property string $phone
 * @property string $message
 * @property string $referrer
 * @property string $submitted_at
 */
class Form1 extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'form_1';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['message', 'referrer'], 'string'],
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
            'message' => Yii::t('forms', 'Message'),
            'referrer' => Yii::t('forms', 'Referrer'),
            'submitted_at' => Yii::t('forms', 'Submitted At'),
        ];
    }
}
