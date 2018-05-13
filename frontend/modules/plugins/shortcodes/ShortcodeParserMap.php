<?php

namespace frontend\modules\plugins\shortcodes;

/**
 * Class ShortcodeParserMap
 * @package frontend\modules\plugins\shortcodes
 */
class ShortcodeParserMap
{
    public $tag;
    public $callback;
    public $config;

    /**
     * PluginDataDto constructor.
     * @param array $data
     */
    public function __construct($data = [])
    {
        foreach ($data as $key => $value) {
            if (property_exists($this, $key)) {
                $this->$key = $value;
            }
        }
    }
}
