<?php

namespace frontend\modules\forms\models;

use Yii;

/**
 * This is the model class for table "form_21".
 *
 * @property int $id
 * @property string $brief_strategy_startdate
 * @property string $brief_strategy_shedule
 * @property string $brief_strategy_agreement
 * @property int $chain_id
 * @property int $chain_submit_id
 * @property string $referrer
 * @property string $submitted_at
 */
class Form21 extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'form_21';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['brief_strategy_startdate', 'brief_strategy_shedule', 'brief_strategy_agreement', 'referrer'], 'string'],
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
            'brief_strategy_startdate' => Yii::t('forms', 'Brief Strategy Startdate'),
            'brief_strategy_shedule' => Yii::t('forms', 'Brief Strategy Shedule'),
            'brief_strategy_agreement' => Yii::t('forms', 'Brief Strategy Agreement'),
            'chain_id' => Yii::t('forms', 'Chain ID'),
            'chain_submit_id' => Yii::t('forms', 'Chain Submit ID'),
            'referrer' => Yii::t('forms', 'Referrer'),
            'submitted_at' => Yii::t('forms', 'Submitted At'),
        ];
    }
}
