<?php

use yii\helpers\Html;
use frontend\modules\blog\components\widgets\lead_generation\LeadGeneration;

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$this->title = Yii::t('blog', 'LEAD_GENERATION');
?>

<div class="main_block_class">
	<span class="main_action_title"><?= Html::encode($this->title) ?></span>
</div>
<?= LeadGeneration::widget(); ?>
