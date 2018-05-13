<?php

namespace frontend\modules\user\models;

use Yii;
use common\models\User as CommonUser;
use frontend\models\HdbkLanguage;
use yii\web\UploadedFile;
use common\models\Invitation;

/**
 * This is the model class for table "profile".
 *
 * @property integer $user_id
 * @property integer $lang_id
 * @property string $first_name
 * @property string $full_name
 * @property string $second_name
 * @property string $city
 * @property string $phone
 * @property string $avatar
 * @property integer $current_team_id
 * @property integer $old_password
 * @property integer $new_password
 * @property integer $repeat_password
 * @property boolean $seo_club_member 
 */
class Profile extends \common\models\Profile
{
    public $old_password;
    public $new_password;
    public $repeat_password;


    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'profile';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['avatar'], 'file', 'extensions' => 'jpg, gif, png'],
            [['first_name','second_name','full_name', 'phone','second_phone'], 'string', 'max' => 45],
            [['city'], 'string', 'max' => 50],
            [['profession'], 'string', 'max' => 100],
            [['biomass_expertise'],'string'],
            ['old_password', 'checkPassword'],
            ['new_password', 'compare', 'compareAttribute' => 'repeat_password'],
            [['new_password'], 'string', 'min' => 6],
            [['repeat_password'], 'string', 'min' => 6],
            ['phone', 'match', 'pattern' => '/^\+?[\d|\s|(|)]*[\d|\s]$/', 'message' => 'INPUT_CORRECT_PHONE_NUMBER'],
            ['phone', 'filter', 'filter'=> 'trim'],
        ];
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            $this->full_name = $this->first_name .' '. $this->second_name;
            return true;
        }
        return false;
    }


	/**
	 * Creates new profile
	 * 
	 * @param integer $userId
	 * @return bool
	 */
    public static function createProfile($userId = false, $invitedUser = false)
    {
        $profile = new Profile();
		
        $profile->user_id = $userId ? $userId : Yii::$app->user->identity->id;
        $profile->lang_id = HdbkLanguage::find()->where(['code' => Yii::$app->language])->one()->id;
		if(!empty($invitedUser)){
			$profile->current_team_id = Invitation::getInvitationTeam($invitedUser->id);
		}
		$requestToJoinSeo = ProfileSeoClubInfo::findOne(['user_id' => $profile->user_id]);
		if (!empty($requestToJoinSeo)) {
			$profile->biomass_expertise = $requestToJoinSeo->personal_info;
			$profile->profession = $requestToJoinSeo->profession;
			
			$profile->first_name = $requestToJoinSeo->first_name;
			$profile->second_name = $requestToJoinSeo->second_name;
			$profile->full_name = $requestToJoinSeo->first_name . ' ' . $requestToJoinSeo->second_name;
		}
        return $profile->save();
    }

	public static function findProfileByUserId($userId)
    {
		$db = Yii::$app->db;
		return $db->cache(function ($db) use ($userId) {
			
		
			return self::findOne($userId);
		}, 3600);
    }
	
	public static function createProfileViaSocial($id, $lang, $name)
    {	
        $profile = new Profile();

        $profile->user_id = $id;
        $profile->lang_id = $lang;
		if(!empty($name)) {
			$profile->full_name = $name;	
		}
		$auth = \Yii::$app->authManager;
		$authorRole = $auth->getRole('client');
		$auth->assign($authorRole, $id);
		
        return $profile->save();
    }
	
	public static function updateProfile($invitedUser = false)
    {

        $profile = self::findOne(['user_id' => $invitedUser->id]);
		$profile->current_team_id = Invitation::getInvitationTeam($invitedUser->id);
        return $profile->save();
    }

    /**
     * Check input password with original user pass
     * @param $attribute
     */
    public function checkPassword($attribute)
    {
        $user = CommonUser::find()->where(['id' => Yii::$app->user->identity->id])->one();

        if (!Yii::$app->security->validatePassword($this->old_password, $user->password_hash)) {
            $this->addError($attribute, 'Incorrect old password');
        }
   }

    public function updateSettings()
    {

        if (UploadedFile::getInstance($this, 'avatar')) {
            if (!$this->uploadFile()) {
                $this->addError('avatar', 'Upload image error');
                return false;
            }
        }


        if (!$this->avatar && $this->oldAttributes['avatar']){
            $this->avatar = $this->oldAttributes['avatar'];
        }

        if ($this->new_password != '' && $this->old_password != '') {
            $user = CommonUser::find()->where(['id' => Yii::$app->user->identity->id])->one();
            $user->password_hash = Yii::$app->security->generatePasswordHash($this->new_password);
            return $this->save() && $user->save();
        }

        return $this->save();
    }

    /**
     * Upload avatars in folder @app/web/images/
     * @return bool
     */
    public function uploadFile()
    {
        $image = UploadedFile::getInstance($this, 'avatar');
        $this->deleteDoubles($this->user_id);
        $ext = explode(".", $image->name);
        $ext = end($ext);
        $this->avatar = $this->user_id .'_'. Yii::$app->security->generateRandomString().".{$ext}";
        $path = Yii::getAlias('@app/web/images/avatars/') . $this->avatar;

        return $image->saveAs($path);
    }

    /**
     * Search in image folder for doubles and delete it
     * @param $id
     */
    private function deleteDoubles($id)
    {
        $files = scandir(Yii::getAlias('@app/web/images/avatars/'));
        foreach ($files as $file) {
            $img_id = explode('_', $file)[0];
            if ($img_id == $id) {
                unlink(Yii::getAlias('@app/web/images/avatars/') . $file);
            }
        }
    }
}
