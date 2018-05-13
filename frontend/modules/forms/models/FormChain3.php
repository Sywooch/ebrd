<?php

namespace frontend\modules\forms\models;

use Yii;

/**
 * This is the model class for table "form_chain_3".
 *
 * @property integer $id
 * @property integer $form_15_id
 * @property integer $form_16_id
 * @property integer $form_17_id
 * @property string $referrer
 * @property string $submitted_at
 * @property string $opened_at
 */
class FormChain3 extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'form_chain_3';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['form_15_id', 'form_16_id', 'form_17_id'], 'integer'],
            [['referrer'], 'string'],
            [['submitted_at', 'opened_at'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('forms', 'ID'),
            'form_15_id' => Yii::t('forms', 'Form 15 ID'),
            'form_16_id' => Yii::t('forms', 'Form 16 ID'),
            'form_17_id' => Yii::t('forms', 'Form 17 ID'),
            'referrer' => Yii::t('forms', 'Referrer'),
            'submitted_at' => Yii::t('forms', 'Submitted At'),
            'opened_at' => Yii::t('forms', 'Opened At'),
        ];
    }
}
