<?php

namespace frontend\modules\forms\models;

use Yii;

/**
 * This is the model class for table "form_20".
 *
 * @property int $id
 * @property string $problem_adhoc
 * @property string $think_adhoc
 * @property string $brief_strategy_problem
 * @property string $brief_strategy_consumer
 * @property string $brief_strategy_motive
 * @property string $brief_strategy_facts
 * @property string $brief_strategy_trust
 * @property string $brief_strategy_tactic
 * @property string $brief_strategy_brand
 * @property string $brief_strategy_steps
 * @property string $brief_strategy_goal
 * @property string $brief_strategy_brandbook
 * @property string $brief_strategy_competitor
 * @property int $chain_id
 * @property int $chain_submit_id
 * @property string $referrer
 * @property string $submitted_at
 */
class Form20 extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'form_20';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['brief_strategy_problem', 'brief_strategy_consumer', 'brief_strategy_motive', 'brief_strategy_facts', 'brief_strategy_trust', 'brief_strategy_tactic', 'brief_strategy_brand', 'brief_strategy_steps', 'brief_strategy_goal', 'brief_strategy_brandbook', 'brief_strategy_competitor', 'referrer'], 'string'],
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
            'brief_strategy_problem' => Yii::t('blog', 'Brief Strategy Problem'),
            'brief_strategy_consumer' => Yii::t('forms', 'Brief Strategy Consumer'),
            'brief_strategy_motive' => Yii::t('forms', 'Brief Strategy Motive'),
            'brief_strategy_facts' => Yii::t('forms', 'Brief Strategy Facts'),
            'brief_strategy_trust' => Yii::t('forms', 'Brief Strategy Trust'),
            'brief_strategy_tactic' => Yii::t('forms', 'Brief Strategy Tactic'),
            'brief_strategy_brand' => Yii::t('forms', 'Brief Strategy Brand'),
            'brief_strategy_steps' => Yii::t('forms', 'Brief Strategy Steps'),
            'brief_strategy_goal' => Yii::t('forms', 'Brief Strategy Goal'),
            'brief_strategy_brandbook' => Yii::t('forms', 'Brief Strategy Brandbook'),
            'brief_strategy_competitor' => Yii::t('forms', 'Brief Strategy Competitor'),
            'chain_id' => Yii::t('forms', 'Chain ID'),
            'chain_submit_id' => Yii::t('forms', 'Chain Submit ID'),
            'referrer' => Yii::t('forms', 'Referrer'),
            'submitted_at' => Yii::t('forms', 'Submitted At'),
        ];
    }
}
