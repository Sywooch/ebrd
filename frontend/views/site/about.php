<?php

/* @var $this yii\web\View */

use yii\helpers\Html;

$this->title = 'About';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-about">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>This is the About page. You may modify the following file to customize its content:</p>

    <code><?= __FILE__ ?></code>
		

	<?php
		$form = frontend\modules\forms\models\Form::findOne(13);
		echo '<pre>';
		\yii\helpers\VarDumper::dump(stripslashes($form->extra_actions));
		echo '</pre>';
//		die();
		echo '<pre>';
		\yii\helpers\VarDumper::dump(\yii\helpers\Json::decode(stripslashes($form->extra_actions)));
		echo '</pre>';
		die();
			
	?>
</div>
