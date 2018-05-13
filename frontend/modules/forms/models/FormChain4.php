<?php

namespace frontend\modules\forms\models;

use Yii;

/**
 * This is the model class for table "form_chain_4".
 *
 * @property int $id
 * @property int $form_20_id
 * @property int $form_21_id
 * @property int $form_22_id
 * @property string $referrer
 * @property string $submitted_at
 * @property string $opened_at
 */
class FormChain4 extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'form_chain_4';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['form_20_id', 'form_21_id', 'form_22_id'], 'integer'],
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
            'form_20_id' => Yii::t('forms', 'Form 20 ID'),
            'form_21_id' => Yii::t('forms', 'Form 21 ID'),
            'form_22_id' => Yii::t('forms', 'Form 22 ID'),
            'referrer' => Yii::t('forms', 'Referrer'),
            'submitted_at' => Yii::t('forms', 'Submitted At'),
            'opened_at' => Yii::t('forms', 'Opened At'),
        ];
    }
}
