<?php

namespace frontend\modules\catalog\models;

use Yii;
use frontend\modules\team\models\Team;
use frontend\modules\plugins\models\PluginsCountryLocationCode;
use frontend\modules\catalog\models\CatalogIndustry;
use frontend\modules\catalog\models\CatalogProjectType;

/**
 * This is the model class for table "catalog_document".
 *
 * @property int $id
 * @property int $client_id
 * @property int $country_id
 * @property string $contract_number
 * @property string $contract_date
 * @property int $industry_id
 * @property int $doc_type_id
 * @property int $project_type
 * @property string $period_start_date
 * @property string $period_end_date
 * @property string $document_description
 * @property file $file
 * @property string $filename
 *
 * @property Team $client
 * @property PluginsCountryLocationCode $country
 * @property CatalogDocType $docType
 * @property CatalogIndustry $industry
 * @property CatalogDocumentToMethodAnalisis[] $catalogDocumentToMethodAnalises
 * @property CatalogDocumentToMethodCollecting[] $catalogDocumentToMethodCollectings
 * @property CatalogDocumentToProject[] $catalogDocumentToProjects
 */
class CatalogDocument extends \yii\db\ActiveRecord
{
	public $project_type = [];
	public $method_analisis = [];
	public $method_collecting = [];
	public $file_collection = [];
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'catalog_document';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['client_id', 'country_id', 'contract_number', 'contract_date', 'industry_id', 'doc_type_id', 'file'], 'required'],
            [['client_id', 'country_id', 'industry_id', 'doc_type_id', 'project_type', 'method_analisis', 'method_collecting'], 'integer'],
            [['contract_date', 'period_start_date', 'period_end_date', 'file_collection'], 'safe'],
            [['document_description', 'filename', 'file', 'filename'], 'string'],
            [['contract_number'], 'string', 'max' => 45],
            [['client_id'], 'exist', 'skipOnError' => true, 'targetClass' => Team::className(), 'targetAttribute' => ['client_id' => 'id']],
            [['doc_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => CatalogDocType::className(), 'targetAttribute' => ['doc_type_id' => 'id']],
            [['industry_id'], 'exist', 'skipOnError' => true, 'targetClass' => CatalogIndustry::className(), 'targetAttribute' => ['industry_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('catalog', 'ID'),
            'client_id' => Yii::t('catalog', 'CATALOG_CLIENT'),
            'country_id' => Yii::t('catalog', 'CATALOG_COUNTRY'),
            'contract_number' => Yii::t('catalog', 'CATALOG_CONTRACT_NUMBER'),
            'contract_date' => Yii::t('catalog', 'CATALOG_CONTRACT_DATE'),
            'industry_id' => Yii::t('catalog', 'CATALOG_INDUSTRY'),
            'doc_type_id' => Yii::t('catalog', 'CATALOG_DOCUMENT_TYPE'),
            'period_start_date' => Yii::t('catalog', 'CATALOG_PERIOD_START'),
            'period_end_date' => Yii::t('catalog', 'CATALOG_PERIOD_END'),
            'document_description' => Yii::t('catalog', 'CATALOG_DOCUMENT_DESCRIPTION'),
            'file' => Yii::t('catalog', 'CATALOG_FILE'),
			'project_type' => Yii::t('catalog', 'CATALOG_PROJECT_TYPE'),
			'method_analisis' => Yii::t('catalog', 'CATALOG_METHOD_ANALISIS_DATA'),
			'method_collecting' => Yii::t('catalog', 'CATALOG_METHOD_COLLECTING_DATA')
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClient()
    {
        return $this->hasOne(Team::className(), ['id' => 'client_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDocType()
    {
        return $this->hasOne(CatalogDocType::className(), ['id' => 'doc_type_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIndustry()
    {
        return $this->hasOne(CatalogIndustry::className(), ['id' => 'industry_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCatalogDocumentToMethodAnalises()
    {
        return $this->hasMany(CatalogDocumentToMethodAnalisis::className(), ['document_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCatalogDocumentToMethodCollectings()
    {
        return $this->hasMany(CatalogDocumentToMethodCollecting::className(), ['document_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCatalogDocumentToProjects()
    {
        return $this->hasMany(CatalogDocumentToProject::className(), ['document_id' => 'id']);
    }
	
	public function getCountry()
    {
        return $this->hasOne(PluginsCountryLocationCode::className(), ['id' => 'country_id']);
    }
	
	
    public function getClients($searchModel)
    {
		$clients = Team::find()->asArray()
				->rightJoin('catalog_document','catalog_document.client_id = team.id');
		if ($searchModel->country_id){
			$clients->andWhere(['catalog_document.country_id' => $searchModel->country_id]);
		}
        return $clients->all();
    }
	
	public function getCountries()
    {
		$countries = PluginsCountryLocationCode::find()->asArray()
				->rightJoin('catalog_document','catalog_document.country_id = plugins_country_location_code.id')
				->all();
        return $countries;
    }
	
	public function getIndustries()
    {
		$industries = CatalogIndustry::find()->asArray()
				->rightJoin('catalog_document','catalog_document.industry_id = catalog_industry.id')
				->all();
		$translated = [];
		foreach ($industries as $industry){
			$translated[] = ['id' => $industry['id'], 'name' => Yii::t('catalog', $industry['name'])];
		}
        return $translated;
    }
	
	public function getProjects()
    {
		$projects = CatalogProjectType::find()->asArray()
				->rightJoin('catalog_document_to_project','catalog_document_to_project.project_type_id = catalog_project_type.id')
				->rightJoin('catalog_document','catalog_document.id = catalog_document_to_project.document_id')
				->all();
        $translated = [];
		foreach ($projects as $project){
			$translated[] = ['id' => $project['id'], 'name' => Yii::t('catalog', $project['name'])];
		}
        return $translated;
    }
	
	public function getMethodsCollection()
    {
		$methodsCollection = CatalogMethodCollectingData::find()->asArray()
				->rightJoin(
						'catalog_document_to_method_collecting',
						'catalog_document_to_method_collecting.method_collecting_id = catalog_method_collecting_data.id'
						)
				->rightJoin('catalog_document','catalog_document.id = catalog_document_to_method_collecting.document_id')
				->all();
        $translated = [];
		foreach ($methodsCollection as $method){
			$translated[] = ['id' => $method['id'], 'name' => Yii::t('catalog', $method['name'])];
		}
        return $translated;
    }
	
	public function getMethodsAnalisis()
    {
		$methodsAnalisis= CatalogMethodAnalysisData::find()->asArray()
				->rightJoin(
						'catalog_document_to_method_analisis',
						'catalog_document_to_method_analisis.method_analisis_id = catalog_method_analysis_data.id'
						)
				->rightJoin('catalog_document','catalog_document.id = catalog_document_to_method_analisis.document_id')
				->all();
        $translated = [];
		foreach ($methodsAnalisis as $method){
			$translated[] = ['id' => $method['id'], 'name' => Yii::t('catalog', $method['name'])];
		}
        return $translated;
    }
	
	public function getDocTypes()
    {
		$docTypes = CatalogDocType::find()->asArray()
				->rightJoin('catalog_document','catalog_document.doc_type_id = catalog_doc_type.id')
				->all();
		$translated = [];
		foreach ($docTypes as $docType){
			$translated[] = ['id' => $docType['id'], 'name' => Yii::t('catalog', $docType['name'])];
		}
        return $translated;
    }
	
}
