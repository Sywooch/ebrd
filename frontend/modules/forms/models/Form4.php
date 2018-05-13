<?php

namespace frontend\modules\forms\models;

use Yii;

/**
 * This is the model class for table "form_4".
 *
 * @property integer $id
 * @property string $full_name
 * @property string $email
 * @property string $phone
 * @property string $company
 * @property string $referrer
 * @property string $submitted_at
 */
class Form4 extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'form_4';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['company', 'referrer'], 'string'],
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
            'company' => Yii::t('forms', 'company'),
            'referrer' => Yii::t('forms', 'Referrer'),
            'submitted_at' => Yii::t('forms', 'Submitted At'),
        ];
    }
}
