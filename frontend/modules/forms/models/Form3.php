<?php

namespace frontend\modules\forms\models;

use Yii;

/**
 * This is the model class for table "form_3".
 *
 * @property integer $id
 * @property string $full_name
 * @property string $email
 * @property string $phone
 * @property string $position
 * @property string $message
 * @property string $file
 * @property string $referrer
 * @property string $submitted_at
 */
class Form3 extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'form_3';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['full_name', 'email', 'phone', 'position', 'file'], 'required'],
            [['message', 'file', 'referrer'], 'string'],
            [['submitted_at'], 'safe'],
            [['full_name', 'email', 'phone', 'position'], 'string', 'max' => 45],
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
            'position' => Yii::t('forms', 'Position'),
            'message' => Yii::t('forms', 'Message'),
            'file' => Yii::t('forms', 'File'),
            'referrer' => Yii::t('forms', 'Referrer'),
            'submitted_at' => Yii::t('forms', 'Submitted At'),
        ];
    }
}
