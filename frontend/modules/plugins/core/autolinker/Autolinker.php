<?php
namespace frontend\modules\plugins\core\autolinker;

use yii\helpers\Url;
use frontend\modules\plugins\BasePlugin;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\web\Response;

/**
 * Plugin Name: Autolinker
 * Version: 1
 * Description: Autolinker plugin
 * Author: BLACK NIGA
 */
class Autolinker extends BasePlugin
{
    
    public static function events()
    {
        return [
            Response::class => [
                Response::EVENT_AFTER_PREPARE => ['getPhrase']
            ]
        ];
    }

    /**
     * @param $event
     */
    public static function getPhrase($event) {
		$model = new \frontend\modules\plugins\models\PluginsAutolinker();

		$countId = $model::find()->count('id');

		for($i = 1; $i <= $countId; $i++) {
			
			$num = $i;
			$dataArray = ArrayHelper::toArray($model->find()->where(['id' => $i])->one());
			
			if (!$content = $event->sender->content)
				return;

			$search = ArrayHelper::getValue($event->data, 'search', $dataArray['keywords']);

			$event->sender->content = str_replace($search, Html::a($dataArray['keywords'], Url::to($dataArray['url']), ['class' => 'profile-link', 'target' => $dataArray['target']]), $content);
	
		}
	}

}
