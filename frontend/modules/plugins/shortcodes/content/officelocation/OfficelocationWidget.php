<?php

namespace frontend\modules\plugins\shortcodes\content\officelocation;

use frontend\modules\plugins\shortcodes\ShortcodeWidget;
use frontend\modules\blog\models\BlogContactOffice;
use Yii;

use yii\widgets\ListView;
use yii\data\ActiveDataProvider;
/**
 * Class YoutubeWidget
 * @package frontend\modules\plugins\shortcodes
 * @author sasha
 */
class OfficelocationWidget extends ShortcodeWidget
{
	/**
     * @var bool office sum
     */
	public $sum;
	/**
     * @var string office name
     */
	public $office_name;
	/**
     * @var string office country
     */
	public $office_country;
	/**
     * @var string office address
     */
	public $office_address;
	/**
     * @var string office email
     */
	public $email;
	
	public $officeclass;
	
	private $defaultLocationCode = 'UA';

	public function init() {
		parent::init();
	}
	
	public function run() {
		$arrayOfOfficies = [];
		
		$localionCode = Yii::$app->userDbIp->run();

		if (!empty($localionCode)) {
				$emptyLangTest = BlogContactOffice::find()->where(['lang_name' => Yii::$app->userDbIp->run()])->one();
				
				if($emptyLangTest == null) {
					$localionCode = $this->defaultLocationCode;
				}
		} else {
			$localionCode = $this->defaultLocationCode;
		}
			
			$query = BlogContactOffice::find()
				->select('id, lang_name, office_name, office_country, office_address, email, phone, lat, lng, content')
				->where(['lang_name' => $localionCode]);	
			
			$offices = BlogContactOffice::find()->where(['lang_name' => $localionCode])->all();
			
			
			if ($this->sum != false) {
			
			$query2 = BlogContactOffice::find()
				->select('id, lang_name, office_name, office_country, office_address, email, phone, lat, lng, content')
				->where(['not', ['lang_name' => $localionCode]]);
		
			$query->union($query2);
			
			$offices2 = BlogContactOffice::find()->where(['not', ['lang_name' => $localionCode]])->all();

			$offices = array_merge($offices, $offices2);
		}

		$dataProvider = new ActiveDataProvider([
			'query' => $query,
			'pagination' => [
				'pageSize' => 30,
			],
		]);
		
		echo ListView::widget([
			'dataProvider' => $dataProvider,
			'summary' => false,
			'itemView' => '_list',
			'options' => [
				'tag' => 'div',
				'class' => "$this->officeclass",
			],
		]);
		

		$create = '';

		foreach ($offices as $offic){
			$create .= 'createMap({coords:{lat: '.$offic->lat.', lng: '.$offic->lng.'}, identif:'.$offic->id.'});'.PHP_EOL;
		}
		
		//$curl = new Curl();
		//$response = $curl->post('https://maps.googleapis.com/maps/api/geocode/json?address=3+Sholudenka+st.,+office+310+Kyiv,+Ukraine+04116&key=AIzaSyC7aRQs0gJvg-xq_VZQ5kz7ArcbSf0HkBY');

		
		$title = Yii::$app->name;
		
		$this->registerJs($create,$title);
	}
	
	protected function registerJs($create,$title) {
		$view = $this->getView();
		$js = <<<JS
		var map;
		function createMap(options) {
			function initMap() {
				var myLatLng = options.coords;
				map = new google.maps.Map(document.getElementById(options.identif), {
				  center: myLatLng,
				  zoom: 15,
				  styles: [
						{
							"featureType": "administrative",
							"elementType": "all",
							"stylers": [
								{
									"saturation": "-100"
								}
							]
						},
						{
							"featureType": "administrative.province",
							"elementType": "all",
							"stylers": [
								{
									"visibility": "off"
								}
							]
						},
						{
							"featureType": "landscape",
							"elementType": "all",
							"stylers": [
								{
									"saturation": -100
								},
								{
									"lightness": 65
								},
								{
									"visibility": "on"
								}
							]
						},
						{
							"featureType": "landscape.man_made",
							"elementType": "all",
							"stylers": [
								{
									"visibility": "off"
								}
							]
						},
						{
							"featureType": "poi",
							"elementType": "all",
							"stylers": [
								{
									"saturation": "14"
								},
								{
									"lightness": "-1"
								},
								{
									"visibility": "simplified"
								},
								{
									"weight": "1"
								}
							]
						},
						{
							"featureType": "poi",
							"elementType": "geometry",
							"stylers": [
								{
									"lightness": "0"
								},
								{
									"saturation": "-100"
								},
								{
									"visibility": "off"
								}
							]
						},
						{
							"featureType": "poi",
							"elementType": "labels.icon",
							"stylers": [
								{
									"visibility": "on"
								}
							]
						},
						{
							"featureType": "poi.attraction",
							"elementType": "geometry",
							"stylers": [
								{
									"visibility": "off"
								}
							]
						},
						{
							"featureType": "poi.government",
							"elementType": "geometry",
							"stylers": [
								{
									"visibility": "off"
								}
							]
						},
						{
							"featureType": "poi.medical",
							"elementType": "geometry",
							"stylers": [
								{
									"visibility": "off"
								}
							]
						},
						{
							"featureType": "poi.park",
							"elementType": "geometry",
							"stylers": [
								{
									"visibility": "off"
								}
							]
						},
						{
							"featureType": "poi.park",
							"elementType": "labels",
							"stylers": [
								{
									"visibility": "on"
								}
							]
						},
						{
							"featureType": "poi.park",
							"elementType": "labels.text",
							"stylers": [
								{
									"visibility": "on"
								}
							]
						},
						{
							"featureType": "poi.park",
							"elementType": "labels.text.fill",
							"stylers": [
								{
									"visibility": "on"
								}
							]
						},
						{
							"featureType": "poi.park",
							"elementType": "labels.text.stroke",
							"stylers": [
								{
									"visibility": "on"
								}
							]
						},
						{
							"featureType": "poi.school",
							"elementType": "all",
							"stylers": [
								{
									"visibility": "off"
								}
							]
						},
						{
							"featureType": "poi.sports_complex",
							"elementType": "all",
							"stylers": [
								{
									"visibility": "on"
								},
								{
									"lightness": "0"
								}
							]
						},
						{
							"featureType": "poi.sports_complex",
							"elementType": "geometry",
							"stylers": [
								{
									"visibility": "off"
								},
								{
									"weight": "1"
								},
								{
									"saturation": "0"
								},
								{
									"lightness": "0"
								}
							]
						},
						{
							"featureType": "poi.sports_complex",
							"elementType": "labels.icon",
							"stylers": [
								{
									"visibility": "on"
								},
								{
									"gamma": "1"
								}
							]
						},
						{
							"featureType": "road",
							"elementType": "all",
							"stylers": [
								{
									"saturation": "-100"
								}
							]
						},
						{
							"featureType": "road.highway",
							"elementType": "all",
							"stylers": [
								{
									"visibility": "simplified"
								}
							]
						},
						{
							"featureType": "road.highway",
							"elementType": "geometry",
							"stylers": [
								{
									"saturation": "0"
								},
								{
									"lightness": "-1"
								}
							]
						},
						{
							"featureType": "road.highway",
							"elementType": "labels",
							"stylers": [
								{
									"weight": "1.37"
								}
							]
						},
						{
							"featureType": "road.highway",
							"elementType": "labels.text",
							"stylers": [
								{
									"saturation": "28"
								},
								{
									"lightness": "24"
								}
							]
						},
						{
							"featureType": "road.arterial",
							"elementType": "all",
							"stylers": [
								{
									"lightness": "30"
								}
							]
						},
						{
							"featureType": "road.arterial",
							"elementType": "geometry",
							"stylers": [
								{
									"saturation": "0"
								},
								{
									"lightness": "-10"
								}
							]
						},
						{
							"featureType": "road.arterial",
							"elementType": "labels",
							"stylers": [
								{
									"saturation": "0"
								}
							]
						},
						{
							"featureType": "road.local",
							"elementType": "all",
							"stylers": [
								{
									"lightness": "10"
								}
							]
						},
						{
							"featureType": "road.local",
							"elementType": "geometry",
							"stylers": [
								{
									"visibility": "on"
								},
								{
									"lightness": "-10"
								},
								{
									"saturation": "1"
								}
							]
						},
						{
							"featureType": "transit",
							"elementType": "all",
							"stylers": [
								{
									"saturation": "0"
								},
								{
									"visibility": "simplified"
								}
							]
						},
						{
							"featureType": "transit",
							"elementType": "geometry",
							"stylers": [
								{
									"visibility": "on"
								},
								{
									"saturation": "0"
								}
							]
						},
						{
							"featureType": "transit.line",
							"elementType": "all",
							"stylers": [
								{
									"visibility": "on"
								}
							]
						},
						{
							"featureType": "transit.station",
							"elementType": "all",
							"stylers": [
								{
									"visibility": "on"
								}
							]
						},
						{
							"featureType": "water",
							"elementType": "geometry",
							"stylers": [
								{
									"hue": "#ffff00"
								},
								{
									"lightness": -25
								},
								{
									"saturation": -97
								}
							]
						},
						{
							"featureType": "water",
							"elementType": "labels",
							"stylers": [
								{
									"lightness": -25
								},
								{
									"saturation": -100
								}
							]
						}
					]
				});
				var marker = new google.maps.Marker({
				  position: myLatLng,
				  icon: '/favicon.ico',
				  map: map,
				  title: '$title'
				});
			}
		  initMap();
		}
JS;
		$view->registerJs($js);
	}
}
