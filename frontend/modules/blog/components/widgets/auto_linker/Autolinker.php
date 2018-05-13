<?php

namespace frontend\modules\blog\components\widgets\auto_linker;

use Yii;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\helpers\BaseUrl;
use yii\base\Widget;
use frontend\modules\plugins\models\PluginsAutolinker;
use frontend\modules\plugins\models\PluginsAutolinkerGlobalSettings;

class Autolinker extends Widget
{
	/**
	 * @var string get id of the necessary post or category
	 */
	public $content;
	/**
	 * @var int static linksCounter
	 */
	private static $linksCounter = 0;
	/**
	 * @var string array for Keywords
	 */
	public $sumKeywords = [];
	
	public function init() {
		parent::init();
	}

	public static function str_replace_once($key, $text)
	{
		if (self::$linksCounter < self::globalLinksQuantity()) {
			$counter = 0;
			$search = $key[0];
			$quantity = $key[2];
			$pattern = "/(\W)(". $search .")(\W)(?![^<|\[]*[>|\]]|[^<>]*<\/(a|form))/ui";
			preg_match($pattern, $text, $matches, PREG_OFFSET_CAPTURE);
			while (!empty($matches) && $counter < $quantity &&
						self::$linksCounter < self::globalLinksQuantity()) {
				$replace = Html::a($matches[2][0], Url::to($key[1]), ['target' => $key[3], 'class' => 'auto-link']);
				$text = substr_replace($text, $replace, $matches[2][1], strlen($search));
				preg_match($pattern, $text, $matches, PREG_OFFSET_CAPTURE);
				$counter++;
				self::$linksCounter++;
			}

			return $text;
		}

		return $text;
	}
	
	public function run() {
		parent::run();

		Widget::begin();
		$status = PluginsAutolinkerGlobalSettings::getGlobalSettingStatusByName();
		if ($status->settings_value <= 0) {
			echo $this->content;
			Widget::end();
			return ;
		}

		$this->globalLinksQuantity();
		$autolinkerRows = PluginsAutolinker::getAutolinkerRows();
		foreach ($autolinkerRows as $row) {
            $rowKeys = array_map('trim', explode(',', $row->keywords));
            foreach ($rowKeys as $keyword) {
                $this->sumKeywords[] = [
                        $keyword,
                        $row->url,
                        $row->links_quantity,
                        $row->target,
                        $row->lang
                ];
            }
		}

		foreach ($this->sumKeywords as $key) {
            if (BaseUrl::canonical() == $key[1]) continue;
            $this->content = $this->str_replace_once($key, $this->content);
		}

		echo $this->content;
		Widget::end();
	}
	
	public static function globalLinksQuantity()
	{
		return Yii::$app->params['settings']['globalAutolinkerSettings']->settings_value;
	}

}
