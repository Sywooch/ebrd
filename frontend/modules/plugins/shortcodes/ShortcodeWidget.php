<?php
namespace frontend\modules\plugins\shortcodes;

use yii\base\Widget;

/**
 * Class Shortcode
 * @package frontend\modules\plugins\components
 */
class ShortcodeWidget extends Widget
{
    /**
     * Content inner shorcode
     * ```
     * [code]...content here...[\code]
     * ```
     * @var string
     */
    public $content;

    /**
     * @param string $name
     * @param mixed $string
     */
    public function __set($name, $string)
    {
        if (property_exists($this, $name)) {
            $this->$name = $string;
        }
    }
}

