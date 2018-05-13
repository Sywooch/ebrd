<?php

namespace frontend\modules\plugins\dto;

use frontend\modules\plugins\helpers\JsonHelper;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;

/**
 * Class ShortcodesDiffDto
 * @package frontend\modules\plugins\dto
 */
class ShortcodesDiffDto
{
    protected $_data = [];

    /**
     * ShortcodesDiffDto constructor.
     * @param array $data
     */
    public function __construct($data = [])
    {
        foreach ($data as $item) {
            $diff = [];
            $handler = ArrayHelper::getValue($item, 'handler_class');
            $tag = ArrayHelper::getValue($item, 'tag');
            $config = ArrayHelper::getValue($item, 'data');
            if ($config) {
                $diff['data'] = $this->prepareConfig($config); // if added new config
            }
            $hash = md5($handler . $tag);
            $this->_data[$hash] = Json::encode($diff);
        }
    }

    /**
     * @return array
     */
    public function getDiff()
    {
        return $this->_data;
    }

    /**
     * @param $data
     * @return array
     */
    protected function prepareConfig($data)
    {
        return array_keys(JsonHelper::decode($data));
    }
}
