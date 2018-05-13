<?php

namespace frontend\modules\forms\models;

use Yii;

/**
 * This is the model class for table "form_10".
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
class Form10 extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'form_10';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['problem_adhoc', 'think_adhoc', 'discribe_object_adhoc', 'main_competitors_adhoc', 'market_segments_adhoc', 'describe_segments', 'countries_covered', 'referrer'], 'string'],
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
            'problem_adhoc' => Yii::t('forms', 'Object Of Study'),
            'think_adhoc' => Yii::t('forms', 'Describe The Propose'),
            'discribe_object_adhoc' => Yii::t('forms', 'Previous Market Segmentation'),
            'main_competitors_adhoc' => Yii::t('forms', 'Applied Conjoint'),
            'market_segments_adhoc' => Yii::t('forms', 'Applied Conjoint'),
            'describe_segments' => Yii::t('forms', 'How Many Attributes'),
            'countries_covered' => Yii::t('forms', 'How Many Attributes'),
            'chain_id' => Yii::t('forms', 'Chain ID'),
            'chain_submit_id' => Yii::t('forms', 'Chain Submit ID'),
            'referrer' => Yii::t('forms', 'Referrer'),
            'submitted_at' => Yii::t('forms', 'Submitted At'),
        ];
    }
}
