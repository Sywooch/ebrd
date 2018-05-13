<?php

namespace frontend\modules\forms\models;

use Yii;

/**
 * This is the model class for table "form_7".
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
class Form7 extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'form_7';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['chain_id', 'chain_submit_id'], 'integer'],
            [['referrer'], 'string'],
            [['submitted_at'], 'safe'],
            [['company_name', 'mailing_address', 'project_manager', 'contact_person', 'website'], 'string', 'max' => 255],
            [['phone', 'email'], 'string', 'max' => 45],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('forms', 'ID'),
            'company_name' => Yii::t('forms', 'Company Name'),
            'mailing_address' => Yii::t('forms', 'Mailing Address'),
            'project_manager' => Yii::t('forms', 'Project Manager'),
            'contact_person' => Yii::t('forms', 'Contact Person'),
            'phone' => Yii::t('forms', 'Phone'),
            'email' => Yii::t('forms', 'Mail'),
            'website' => Yii::t('forms', 'Website'),
            'chain_id' => Yii::t('forms', 'Chain ID'),
            'chain_submit_id' => Yii::t('forms', 'Chain Submit ID'),
            'referrer' => Yii::t('forms', 'Referrer'),
            'submitted_at' => Yii::t('forms', 'Submitted At'),
        ];
    }
}
