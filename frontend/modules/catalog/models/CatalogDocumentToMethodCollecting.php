<?php

namespace frontend\modules\catalog\models;

use Yii;

/**
 * This is the model class for table "catalog_document_to_method_collecting".
 *
 * @property int $id
 * @property int $document_id
 * @property int $method_collecting_id
 *
 * @property CatalogDocument $document
 * @property CatalogMethodCollectingData $methodCollecting
 */
class CatalogDocumentToMethodCollecting extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'catalog_document_to_method_collecting';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['document_id', 'method_collecting_id'], 'required'],
            [['document_id', 'method_collecting_id'], 'integer'],
            [['document_id'], 'exist', 'skipOnError' => true, 'targetClass' => CatalogDocument::className(), 'targetAttribute' => ['document_id' => 'id']],
            [['method_collecting_id'], 'exist', 'skipOnError' => true, 'targetClass' => CatalogMethodCollectingData::className(), 'targetAttribute' => ['method_collecting_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('catalog', 'ID'),
            'document_id' => Yii::t('catalog', 'Document ID'),
            'method_collecting_id' => Yii::t('catalog', 'Method Collecting ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDocument()
    {
        return $this->hasOne(CatalogDocument::className(), ['id' => 'document_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMethodCollecting()
    {
        return $this->hasOne(CatalogMethodCollectingData::className(), ['id' => 'method_collecting_id']);
    }
}
