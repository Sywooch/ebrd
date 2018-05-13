<?php

namespace frontend\modules\forms\models;

use Yii;

/**
 * This is the model class for table "form_22".
 *
 * @property int $id
 * @property string $brief_strategy_client
 * @property string $brief_strategy_project
 * @property string $brief_strategy_date
 * @property string $brief_strategy_bywhom
 * @property int $chain_id
 * @property int $chain_submit_id
 * @property string $referrer
 * @property string $submitted_at
 */
class Form22 extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'form_22';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['brief_strategy_client', 'brief_strategy_project', 'brief_strategy_date', 'brief_strategy_bywhom', 'referrer'], 'string'],
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
            'brief_strategy_client' => Yii::t('forms', 'Brief Strategy Client'),
            'brief_strategy_project' => Yii::t('forms', 'Brief Strategy Project'),
            'brief_strategy_date' => Yii::t('forms', 'Brief Strategy Date'),
            'brief_strategy_bywhom' => Yii::t('forms', 'Brief Strategy Bywhom'),
            'chain_id' => Yii::t('forms', 'Chain ID'),
            'chain_submit_id' => Yii::t('forms', 'Chain Submit ID'),
            'referrer' => Yii::t('forms', 'Referrer'),
            'submitted_at' => Yii::t('forms', 'Submitted At'),
        ];
    }
}
