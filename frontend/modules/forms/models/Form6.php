<?php

namespace frontend\modules\forms\models;

use Yii;

/**
 * This is the model class for table "form_6".
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
class Form6 extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'form_6';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['geography', 'timeline', 'budget', 'authority', 'referrer'], 'string'],
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
            'geography' => Yii::t('forms', 'Geography'),
            'timeline' => Yii::t('forms', 'Timeline'),
            'budget' => Yii::t('forms', 'Budget'),
            'authority' => Yii::t('forms', 'Authority'),
            'chain_id' => Yii::t('forms', 'Chain ID'),
            'chain_submit_id' => Yii::t('forms', 'Chain Submit ID'),
            'referrer' => Yii::t('forms', 'Referrer'),
            'submitted_at' => Yii::t('forms', 'Submitted At'),
        ];
    }
}
