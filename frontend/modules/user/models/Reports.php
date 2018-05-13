<?php

namespace frontend\modules\user\models;

use Yii;
use common\models\User;
use yii\helpers\ArrayHelper;
use frontend\models\HdbkLanguage;
use frontend\modules\letter\models\Letter;
use yii\helpers\Html;
use common\models\Invitation;
use common\models\CabinetHdbkReportType;
use yii\data\ActiveDataProvider;
use yii\web\UploadedFile;

/**
 * This is the model class for table "reports".
 *
 * @property integer $id
 * @property string $name
 * @property string $report_content
 * @property string $user_id
 * @property string $created_at
 * @property string $updated_at
 */
class Reports extends \yii\db\ActiveRecord
{
	
	public $thumbanil;

	public function behaviors()
    {
		return [
				[
				'class' => \yii\behaviors\TimestampBehavior::className(),
				'value' => function($event){
					return date("Y-m-d H:i:s");
				}
			]
		];
    }
	
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'reports';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
			[['file'], 'file', 'extensions' => 'pdf', 'maxSize' => 20000000, 'tooBig' => 'Limit is 20 MB'],
            [['name','report_description'], 'required'],
            [['report_content'], 'url'],
			[['nav'], 'string'],
			[['type_id','thumbnail'], 'safe'],
            [['created_at', 'updated_at'], 'safe'],
            [['name'], 'string', 'max' => 255],
        ];
    }
	

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('blog', 'ID'),
            'name' => Yii::t('blog', 'NAME'),
			'report_content' => Yii::t('blog', 'BI_LINK_WARNING'),
			'type_id' => Yii::t('blog', 'CATEGORY'),
            'created_at' => Yii::t('blog', 'CREATED_AT'),
            'updated_at' => Yii::t('blog', 'UPDATED_AT'),
        ];
    }

	public function beforeSave($insert)
	{
		if (parent::beforeSave($insert)) {
			$this->thumbnail = random_int(1, 35);
			return true;
		}
		return true;
	}
	
	public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
	
	public function updateSettings()
    {
		if (UploadedFile::getInstance($this, 'file')) {
            if (!$this->uploadFile()) {
                $this->addError('file', 'Upload image error');
                return false;
            }
        }

        return $this->save();
    }
	
	public function uploadFile()
    {
		$file = UploadedFile::getInstance($this, 'file');
        $this->file = $file->name;
        $path = Yii::getAlias('@app/web/reports/') . $file;
        return $file->saveAs($path);
    }
	
	public function getReports()
    {
        return $this->hasMany(MapTeamUserReport::className(), ['report_id' => 'id']);
    }
	
	public function getReportType()
    {
        return $this->hasOne(CabinetHdbkReportType::className(), ['type_id' => 'id']);
    }
	
	public static function getReportById($id)
    {
        return self::find()->where(['id' => $id])->one();
    }
	
	public function getAllUserReports()
    {
		$query = self::find();
		
		$query->where(['user_id' => Yii::$app->user->id])->joinWith('reports');
		
		if (!empty(\Yii::$app->user->identity->profile->currentTeam)) {
            $query->orWhere(['team_id' => \Yii::$app->user->identity->profile->currentTeam])->joinWith('reports');
        }
		
        return $query->column();
    }
	
	public function sendReportEmail($user = false, $team = false, $reportModel = false, $resend = false)
    {
		if($resend){
			$emailName = 'resend_mail';
		}else{
			$emailName = CabinetHdbkReportType::getEmailNameByType($reportModel->type_id)->email_name;
		}
		$activeUsers = User::getActiveUsersById($user);
		$activeUsersInTeam = Invitation::getActiveUsersInTeam($team);
		
		if(!empty($activeUsers) || !empty($activeUsersInTeam)){
			$languages = ArrayHelper::map(HdbkLanguage::getLanguagesSymbols(), 'code', 'id');
			$language = \Yii::$app->language;
			$langId = $languages[$language];
			$model = Letter::find()->where(['name' => $emailName, 'lang_id' => $langId])->one() ??
					Letter::find()->where(['name' => $emailName, 'lang_id' => $languages['en']])->one();
			$message = self::composeReportEmail($model,$reportModel);
			$subject = $model->title;
			$mails = [];
			if(!empty($activeUsers)){
				foreach ($activeUsers as $activeUser){
					if(!in_array($activeUser->email, $mails)){
						array_push($mails, $activeUser->email);
					}
				}
			}
			if(!empty($activeUsersInTeam)){
				foreach($activeUsersInTeam as $activeUserInTeam){
					if(!in_array($activeUserInTeam->email, $mails)){
						array_push($mails, $activeUserInTeam->email);
					}
				}
			}
			return \Yii::$app->mailer->compose()
					->setFrom([\Yii::$app->params['adminEmail'] => Yii::$app->name])
					->setTo($mails)
					->setHtmlBody($message)
					->setSubject($subject)
					->send();
		}	
    }
	
	private static function composeReportEmail($model, $report)
    {
		$reportLink = \Yii::$app->urlManager->createAbsoluteUrl(['cabinet/view?id='.$report->id]);
        $reportLink = Html::a(Html::encode($report->name), $reportLink);
        $model->content = preg_replace("/{{reportLink}}/ui", $reportLink, $model->content);
		if(\Yii::$app->language == 'uk'){
			$model->content .= \Yii::$app->params['settings']['sing_uk'];
		}else{
			$model->content .= \Yii::$app->params['settings']['sing_en'];
		}
        return $model->content;
    }
	
	public function getResults() 
	{ 
		return new ActiveDataProvider([
			'query' => self::find()
				->where([
					'reports.type_id' => 6,
					'map_team_user_report.user_id' => Yii::$app->user->identity->id
				])
				->joinWith('reports'),
		]);
	}
	
	public function userHasResults() 
	{ 
		return self::find()
				->where([
					'reports.type_id' => 6,
					'map_team_user_report.user_id' => Yii::$app->user->identity->id
				])
				->joinWith('reports')
				->all();
	}
	
	public function getIndustrialStatistic() 
	{
		return new ActiveDataProvider([
			'query' => self::find()
				->where([
					'type_id' => 2
				]),
			'sort'=> ['defaultOrder' => ['created_at'=>SORT_DESC]]
		]);
	}
	
	public function getNps() 
	{
		return new ActiveDataProvider([
			'query' => self::find()
				->where([
					'type_id' => 3
				]),
			'sort'=> ['defaultOrder' => ['created_at'=>SORT_DESC]]
		]);
	}
	
	public function getGeomarketing() 
	{
		return new ActiveDataProvider([
			'query' => self::find()
				->where([
					'type_id' => 4
				]),
			'sort'=> ['defaultOrder' => ['created_at'=>SORT_DESC]]
		]);
	}
	
	public function getManuals() 
	{
		return new ActiveDataProvider([
			'query' => self::find()
				->where([
					'type_id' => 5
				]),
			'sort'=> ['defaultOrder' => ['created_at'=>SORT_DESC]]
		]);
	}
	
	public static function getTypeIdByGet($request)
	{
		if(!empty($request)){
			if(!empty($request['id'])){
				$id = $request['id'];
				$report = self::getReportById($id);
				if(!empty($report)){
					$type = $report->type_id;
					return $type;
				}else{
					return NULL;
				}
			}else{
				return NULL;
			}
		}else{
			return NULL;
		}
	}
}
