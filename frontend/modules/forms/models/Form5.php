<?php

namespace frontend\modules\forms\models;

use Yii;

/**
 * This is the model class for table "form_5".
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
class Form5 extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'form_5';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['object_of_study', 'describe_the_propose', 'previous_market_segmentation', 'applied_conjoint', 'how_many_attributes', 'referrer'], 'string'],
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
            'object_of_study' => Yii::t('forms', 'Object Of Study'),
            'describe_the_propose' => Yii::t('forms', 'Describe The Propose'),
            'previous_market_segmentation' => Yii::t('forms', 'Previous Market Segmentation'),
            'applied_conjoint' => Yii::t('forms', 'Applied Conjoint'),
            'how_many_attributes' => Yii::t('forms', 'How Many Attributes'),
            'chain_id' => Yii::t('forms', 'Chain ID'),
            'chain_submit_id' => Yii::t('forms', 'Chain Submit ID'),
            'referrer' => Yii::t('forms', 'Referrer'),
            'submitted_at' => Yii::t('forms', 'Submitted At'),
        ];
    }
}
