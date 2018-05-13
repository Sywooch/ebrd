<?php

use yii\widgets\ListView;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>

<div class="admin-test-analytic">
	<div class="flex flex__jcsb flex__aic">
		<div class="admin-test-analytic__id">ID</div>
		<div class="admin-test-analytic__email">E-mail</div>
		<div class="admin-test-analytic__mark">Mark</div>
		<div class="admin-test-analytic__view">View Result</div>
	</div>
	<?= ListView::widget([
		'dataProvider' => $dataProvider,
		'itemView' => '_list',
		'summary' => false,
		'options' => [
			'class' => 'admin-test-analytic__container'
		],
		'itemOptions' => [
			'class' => 'admin-test-analytic__item'
		],
	]); ?>
</div>