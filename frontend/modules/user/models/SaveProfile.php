<?php

namespace frontend\modules\user\models;

use yii\base\Model;
use frontend\modules\user\models\Profile;
use Yii;

/**
 * @property integer $id
 * @property string $language
 * @property string $message
 * @property string $translation Translation of the message
 */
class SaveProfile extends Model
{
	public $user_first_name;
    public $user_last_name;
	/**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_first_name','user_last_name'], 'string'],
        ];
    }
	
	/**
	 * Saves new translation or update old one
	 * 
	 * @return bool If new translation saved successfully
	 */
	public function save()
	{
		$updatedProfile = Yii::$app->user->identity->profile;
		
		$updatedProfile = Yii::$app->user->identity->profile;
		
		$updatedProfile->{Yii::$app->request->post()['flag']} = Yii::$app->request->post()['val'];

		$updatedProfile->save();
	}
}

