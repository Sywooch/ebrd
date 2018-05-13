<?php

namespace frontend\modules\forms\models;

use Yii;

/**
 * This is the model class for table "form_15".
 *
 * @property integer $id
 * @property string $object_of_study
 * @property string $describe_the_propose
 * @property string $previous_market_segmentation
 * @property string $applied_conjoint
 * @property string $how_many_attributes
 * @property integer $chain_id
 * @property integer $chain_submit_id
 * @property string $referrer
 * @property string $submitted_at
 */
class Form15 extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'form_15';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['email', 'company_name', 'edrop_code', 'website', 'money', 'company_description', 'referrer'], 'string'],
            [['chain_id', 'chain_submit_id'], 'integer'],
            [['submitted_at'], 'safe'],
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
            'company_name' => Yii::t('forms', 'Company Name'),
            'edrop_code' => Yii::t('forms', 'Edrop code'),
            'website' => Yii::t('forms', 'website'),
            'money' => Yii::t('forms', 'money'),
			'company_description' => Yii::t('forms', 'company_description'),
            'chain_id' => Yii::t('forms', 'Chain ID'),
            'chain_submit_id' => Yii::t('forms', 'Chain Submit ID'),
            'referrer' => Yii::t('forms', 'Referrer'),
            'submitted_at' => Yii::t('forms', 'Submitted At'),
        ];
    }
}
