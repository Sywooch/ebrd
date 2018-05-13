<?php

namespace frontend\modules\catalog\models;

use Yii;

/**
 * This is the model class for table "catalog_document_to_method_analisis".
 *
 * @property int $id
 * @property int $document_id
 * @property int $method_analisis_id
 *
 * @property CatalogDocument $document
 * @property CatalogMethodAnalysisData $methodAnalisis
 */
class CatalogDocumentToMethodAnalisis extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'catalog_document_to_method_analisis';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['document_id', 'method_analisis_id'], 'required'],
            [['document_id', 'method_analisis_id'], 'integer'],
            [['document_id'], 'exist', 'skipOnError' => true, 'targetClass' => CatalogDocument::className(), 'targetAttribute' => ['document_id' => 'id']],
            [['method_analisis_id'], 'exist', 'skipOnError' => true, 'targetClass' => CatalogMethodAnalysisData::className(), 'targetAttribute' => ['method_analisis_id' => 'id']],
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
            'method_analisis_id' => Yii::t('catalog', 'Method Analisis ID'),
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
    public function getMethodAnalisis()
    {
        return $this->hasOne(CatalogMethodAnalysisData::className(), ['id' => 'method_analisis_id']);
    }
}
