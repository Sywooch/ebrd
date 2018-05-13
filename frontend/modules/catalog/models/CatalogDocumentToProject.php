<?php

namespace frontend\modules\catalog\models;

use Yii;

/**
 * This is the model class for table "catalog_document_to_project".
 *
 * @property int $id
 * @property int $document_id
 * @property int $project_type_id
 *
 * @property CatalogDocument $document
 * @property CatalogProjectType $projectType
 */
class CatalogDocumentToProject extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'catalog_document_to_project';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['document_id', 'project_type_id'], 'required'],
            [['document_id', 'project_type_id'], 'integer'],
            [['document_id'], 'exist', 'skipOnError' => true, 'targetClass' => CatalogDocument::className(), 'targetAttribute' => ['document_id' => 'id']],
            [['project_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => CatalogProjectType::className(), 'targetAttribute' => ['project_type_id' => 'id']],
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
            'project_type_id' => Yii::t('catalog', 'Project Type ID'),
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
    public function getProjectType()
    {
        return $this->hasOne(CatalogProjectType::className(), ['id' => 'project_type_id']);
    }
}
