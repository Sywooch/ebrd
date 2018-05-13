<?php

namespace frontend\modules\forms\models;

use Yii;

/**
 * This is the model class for table "form_13".
 *
 * @property integer $id
 * @property string $company_name
 * @property string $mailing_address
 * @property string $project_manager
 * @property string $contact_person
 * @property string $phone
 * @property string $mail
 * @property string $website
 * @property integer $chain_id
 * @property integer $chain_submit_id
 * @property string $referrer
 * @property string $submitted_at
 */
class Form13 extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'form_13';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['referrer'], 'string'],
            [['submitted_at'], 'safe'],
            [['full_name', 'email'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('forms', 'ID'),
			'full_name' => Yii::t('forms', 'FULL_NAME'),
			'email' => Yii::t('forms', 'EMAIL'),
            'referrer' => Yii::t('forms', 'Referrer'),
            'submitted_at' => Yii::t('forms', 'Submitted At'),
        ];
    }
}
