
<div class="main-page-item">  
    <?php // echo $model->content ?>
	<?= frontend\modules\blog\components\widgets\auto_linker\Autolinker::widget([
		'content' => $model->content
	]);
	?>
	
</div>
