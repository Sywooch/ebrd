<?php
namespace frontend\modules\plugins\shortcodes\bootstrap\widgets;

/**
 * Class Row
 * @package lo\shortcodes\bootstrap\widgets
 * @author Lukyanov Andrey <loveorigami@mail.ru>
 */
class Row extends BootstrapWidget
{
    /**
     * init widget
     */
    public function init()
    {
        parent::init();

        $this->options = [
            'class' => 'row'
        ];
    }
}