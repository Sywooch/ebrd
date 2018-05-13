<?php

namespace frontend\modules\forms\models;

use Yii;

/**
 * This is the model class for table "form_11".
 *
 * @property integer $id
 * @property string $geography
 * @property string $timeline
 * @property string $budget
 * @property string $authority
 * @property integer $chain_id
 * @property integer $chain_submit_id
 * @property string $referrer
 * @property string $submitted_at
 */
class Form11 extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'form_11';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['period_of_market', 'measure_success', 'project_presented','referrer'], 'string'],
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
            'period_of_market' => Yii::t('forms', 'Geography'),
            'measure_success' => Yii::t('forms', 'Timeline'),
            'project_presented' => Yii::t('forms', 'Budget'),
            'chain_id' => Yii::t('forms', 'Chain ID'),
            'chain_submit_id' => Yii::t('forms', 'Chain Submit ID'),
            'referrer' => Yii::t('forms', 'Referrer'),
            'submitted_at' => Yii::t('forms', 'Submitted At'),
        ];
    }
}
