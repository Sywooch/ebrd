<?php

namespace frontend\modules\forms\models;

use Yii;

/**
 * This is the model class for table "form_chain_1".
 *
 * @property integer $id
 * @property integer $form_5_id
 * @property integer $form_6_id
 * @property integer $form_7_id
 * @property string $referrer
 * @property string $submitted_at
 * @property string $opened_at
 */
class FormChain1 extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'form_chain_1';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['form_5_id', 'form_6_id', 'form_7_id'], 'integer'],
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
            'form_5_id' => Yii::t('forms', 'Form 5 ID'),
            'form_6_id' => Yii::t('forms', 'Form 6 ID'),
            'form_7_id' => Yii::t('forms', 'Form 7 ID'),
            'referrer' => Yii::t('forms', 'Referrer'),
            'submitted_at' => Yii::t('forms', 'Submitted At'),
            'opened_at' => Yii::t('forms', 'Opened At'),
        ];
    }
}
