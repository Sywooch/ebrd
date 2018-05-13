<?php

namespace frontend\components\geolocation;

error_reporting(E_ALL);
use Yii;
use frontend\modules\plugins\models\UserLocationIp;

/**
 * Description of UserLocationIp
 *
 * @author sasha
 */

class UserIp extends \yii\base\Component
{
	/**
	 * @var integer drop time from target ip
	 */
	private $userIp;

	/**
	 * @var integer drop time from target ip
	 */
	public $ipDropTime = 5259486;
	
	public function init() {
		parent::init();
	}
	
	public function run() 
	{
		/**
		 * @var integer just unix time
		*/
		$unixTime = time();
		
		/**
		 * @var float get user localion ip
		*/
		$ip = Yii::$app->request->userIP; 
		$model = new UserLocationIp();
		
		$res = $model::getUserIp($ip);

		if (!isset($res->user_ip)) {
			
			if (Yii::$app->geolocation->getInfo() === false) {
				$userIp['geoplugin_countryCode'] = 'UA';
			} else {
				$userIp = Yii::$app->geolocation->getInfo();
			}
			
			$model->user_ip = $ip;
			$model->time_counter = $unixTime;
			$model->location = $userIp['geoplugin_countryCode'];
			$model->save();
			
			return $model->location;
		} else {
			if (Yii::$app->geolocation->getInfo() === false) {
//				echo 'err';
				$userIp['geoplugin_countryCode'] = 'UA';
			} else {
//			echo 'err';
				$userIp = Yii::$app->geolocation->getInfo();
			}
			if ((int) $res->time_counter + (int) $this->ipDropTime <= $unixTime) {
				$res->user_ip = $ip;
				$res->time_counter = $unixTime;
				$res->location = $userIp['geoplugin_countryCode'];
				$res->update();
			}
		}
				
		return (!empty($res->location)) ?  $res->location : 'UA';
	}
	
}