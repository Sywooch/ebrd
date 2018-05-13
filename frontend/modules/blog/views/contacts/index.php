<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel frontend\modules\blog\models\BlogContactOfficeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('blog', 'CONTACT_OFFICES');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="blog-contact-office-index">
	<div class="main_block_class">
		<span class="main_action_title"><?= Html::encode($this->title) ?></span>
		<span class="main_action_class"><?= Html::a(Yii::t('blog', 'CREATE_CONTACT_OFFICE'), ['create'], ['class' => 'btn btn-success']) ?></span>
		<span class="main_action_class"><?= Html::a(Yii::t('blog', 'ADD_A_SEPARATE_PHONE_NUMBER'), ['phones'], ['class' => 'btn btn-primary']) ?></span>
	</div>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
	
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
		'layout'=>'<div class="grid_over">{items}</div>{pager}',
        'columns' => [
            'id',
            'office_name',
            ['class' => 'yii\grid\ActionColumn'],
            'office_country',
            'office_address',
            'email:email',
            'phone',
			'content',
            'lang_name',
        ],
    ]); ?>
<?php Pjax::end(); ?></div>