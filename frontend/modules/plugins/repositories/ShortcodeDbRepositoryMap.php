<?php

namespace frontend\modules\plugins\repositories;
use frontend\modules\plugins\helpers\JsonHelper;
use frontend\modules\plugins\models\Shortcode;

/**
 * Class ShortcodeDbRepositoryMap
 * @package frontend\modules\plugins\repositories
 */
class ShortcodeDbRepositoryMap
{
    public $id;
    public $app_id;
    public $handler_class;
    public $tag;
    public $tooltip;
    public $data;
    public $text;
    public $status = Shortcode::STATUS_ACTIVE;

    /**
     * ShortcodeDbRepositoryMap constructor.
     * @param array $data
     */
    public function __construct($data = [])
    {
        foreach ($data as $key => $value) {
            if (property_exists($this, $key)) {
                $this->$key = $value;
            }
        }
        if ($this->data) {
            $this->data = JsonHelper::encode($this->data);
        }
    }
}
