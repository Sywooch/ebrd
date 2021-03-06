<?php
namespace frontend\modules\plugins\shortcodes\content\codehighlight;

use yii\web\AssetBundle;

/**
 * Class CodeAsset
 * @package frontend\modules\plugins\plugins\code
 */
class CodeAsset extends AssetBundle
{
    /**
     * @var string
     */
    public $sourcePath = '@vendor/components/highlightjs';

    /**
     * @var array
     */
    public $js = ['highlight.pack.js'];

    /**
     * @var string
     */
    public static $style = 'monokai';

    /**
     * @inheritdoc
     */
    public static function register($view)
    {
        $thisBundle = \Yii::$app->getAssetManager()->getBundle(__CLASS__);
        $thisBundle->css[] = sprintf('styles/%s.css', self::$style);
        return parent::register($view);
    }
}