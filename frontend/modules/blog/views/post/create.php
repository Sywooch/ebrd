<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model frontend\modules\blog\models\BlogPost */

$this->title = Yii::t('blog', 'CREATE_POST');
$this->params['breadcrumbs'][] = ['label' => Yii::t('blog', 'POSTS'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="blog-post-create">

    <div class="main_block_class">
		<span class="main_action_title"><?= Html::encode($this->title) ?></span>
	</div>

    <?= $this->render('_form', [
        'model' => $model,
		'items' => $items,
		'parent' => $parent,
		'entity' => '',
		'authors' => $authors,
    ]) ?>

</div>
