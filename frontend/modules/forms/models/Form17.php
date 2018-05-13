<?php

namespace frontend\modules\forms\models;

use Yii;

/**
 * This is the model class for table "form_17".
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
class Form17 extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'form_17';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['date', 'quantity', 'operation_description', 'operation_money', 'documents', 'referrer'], 'string'],
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
            'date' => Yii::t('forms', 'date'),
            'quantity' => Yii::t('forms', 'quantity'),
            'operation_description' => Yii::t('forms', 'operation_description'),
            'operation_money' => Yii::t('forms', 'operation_money'),
            'documents' => Yii::t('forms', 'documents'),
            'chain_id' => Yii::t('forms', 'Chain ID'),
            'chain_submit_id' => Yii::t('forms', 'Chain Submit ID'),
            'referrer' => Yii::t('forms', 'Referrer'),
            'submitted_at' => Yii::t('forms', 'Submitted At'),
        ];
    }
}
