<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model frontend\modules\blog\models\BlogContactOffice */

$this->title = Yii::t('blog', 'CONTACT_OFFICES');
$this->params['breadcrumbs'][] = ['label' => Yii::t('blog', 'CONTACT_OFFICES'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="blog-contact-office-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
