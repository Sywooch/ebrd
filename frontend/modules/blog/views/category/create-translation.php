<?php

use yii\helpers\Html;
use yii\helpers\Url;


/* @var $this yii\web\View */
/* @var $model frontend\modules\blog\models\BlogPost */

$this->title = Yii::t('blog', 'Cleate Translation');
$this->params['breadcrumbs'][] = ['label' => Yii::t('blog', 'CATEGORIES'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $old_model->name, 'url' => Url::to(['/blog/category/view', 'id' => $old_model->id])];
$this->params['breadcrumbs'][] = ['label' => Yii::t('blog', 'UPDATE'), 'url' => Url::to(['/blog/category/update', 'id' => $old_model->id])];
$this->params['breadcrumbs'][] = $this->title;
?>


<div class="blog-post-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_translate_form', [
        'model' => $model,
        'items' => $items,
        'groups' => $groups,
        'parent' => $parent,
        'old_model' => $old_model,
        'translateRow' => $translateRow,
        'newLangCode' => $newLangCode,
        'categoryList' => $categoryList,
        'oldCategory' => $oldCategory,
        'oldGroup' => $oldGroup,
		'layouts' => $layouts,
		'oldLayout' => $oldLayout,
		'flag' => $flag,
		'catFlag' => $catFlag,
    ]) ?>

</div>
