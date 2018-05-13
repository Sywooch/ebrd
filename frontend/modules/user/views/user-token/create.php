<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\UserToken */

$this->title = Yii::t('user', 'Create User Token');
$this->params['breadcrumbs'][] = ['label' => Yii::t('user', 'User Tokens'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-token-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
