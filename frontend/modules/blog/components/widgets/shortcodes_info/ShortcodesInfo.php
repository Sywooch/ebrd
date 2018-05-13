<?php

namespace frontend\modules\blog\components\widgets\shortcodes_info;

use Yii;
use yii\helpers\Html;
use yii\base\Widget;
use yii\widgets\ActiveForm;
use yii\bootstrap\Modal;
use frontend\modules\plugins\models\Shortcode;
use frontend\modules\plugins\models\Plugin;
use frontend\modules\plugins\models\ShortcodeInfo;
use frontend\modules\blog\components\widgets\shortcodes_info\ClipboardJsWidget;

class ShortcodesInfo extends Widget {

    public function init() {
        parent::init();
    }

    public function run() {
        parent::run();

        Widget::begin();

        $mainShortcode = new Shortcode();
        $mainShortcode = $mainShortcode->find()
                ->select('plugin_id, tooltip')
                ->all();
        
        $tagsToCopy = new ShortcodeInfo();
        $tags = $tagsToCopy->find()
                ->all();
        $info = new Plugin();

        Modal::begin([
            'toggleButton' => [
                'tag' => 'button',
                'class' => 'btn btn-sm btn-info btn-shortcode',
                'label' => 'Shortcodes',
            ]
        ]);
        ?>
        <?php $form = ActiveForm::begin(); ?>

        <?php ActiveForm::end(); ?>

        <?php 
        
        ?>
    <div class="shortcode_modal_add">
        <?= Html::a(Yii::t('blog', 'ADD_NEW_SHORTCODE'), ['/plugins/shortcode/add'], ['class' => 'btn btn-sm btn-success']) ?>
    </div>
        <?php
        foreach ($mainShortcode as $shortcode) {
            
            $codeInfo = $info->find()->where(['id' => $shortcode->plugin_id])->one();
            echo '<div class="shortcode_group"><div class="shortcode_label">' . $codeInfo->text . '</div><pre>' . $shortcode->tooltip . '</pre></div>';
            
            foreach ($tags as $tag) { 
                
                if($tag->shortcode_id == $codeInfo->id) {
					$id = 'clipboard' . strval($tag->id);
                    echo '<div class="shortcode_item"><div class="shortcode_label">' . $tag->description .'</div><pre id="'.$id.'">' . $tag->tag . '</pre>';

					echo ClipboardJsWidget::widget([
						'inputId' => "#" . $id,
						'label' => 'Copy',
						'htmlOptions' => ['class' => 'btn'],
						'tag' => 'button',
					]);
					echo '</div>';
				}
                
            }

        }

        Modal::end();

        Widget::end();
    }

}
