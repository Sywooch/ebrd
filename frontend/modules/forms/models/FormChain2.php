<?php

namespace frontend\modules\forms\models;

use Yii;

/**
 * This is the model class for table "form_chain_2".
 *
 * @property integer $id
 * @property integer $form_10_id
 * @property integer $form_11_id
 * @property integer $form_12_id
 * @property string $referrer
 * @property string $submitted_at
 * @property string $opened_at
 */
class FormChain2 extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'form_chain_2';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['form_10_id', 'form_11_id', 'form_12_id'], 'integer'],
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
            'form_10_id' => Yii::t('forms', 'Form 5 ID'),
            'form_11_id' => Yii::t('forms', 'Form 6 ID'),
            'form_12_id' => Yii::t('forms', 'Form 7 ID'),
            'referrer' => Yii::t('forms', 'Referrer'),
            'submitted_at' => Yii::t('forms', 'Submitted At'),
            'opened_at' => Yii::t('forms', 'Opened At'),
        ];
    }
}
