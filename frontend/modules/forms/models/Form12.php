<?php

namespace frontend\modules\forms\models;

use Yii;

/**
 * This is the model class for table "form_12".
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
class Form12 extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'form_12';
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
            [['target_date', 'timeline', 'approvals', 'client', 'date', 'prepered'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('forms', 'ID'),
            'target_date' => Yii::t('forms', 'Company Name'),
            'timeline' => Yii::t('forms', 'Mailing Address'),
            'approvals' => Yii::t('forms', 'Project Manager'),
            'client' => Yii::t('forms', 'Contact Person'),
            'date' => Yii::t('forms', 'Phone'),
            'prepered' => Yii::t('forms', 'Mail'),
            'chain_id' => Yii::t('forms', 'Chain ID'),
            'chain_submit_id' => Yii::t('forms', 'Chain Submit ID'),
            'referrer' => Yii::t('forms', 'Referrer'),
            'submitted_at' => Yii::t('forms', 'Submitted At'),
        ];
    }
}
