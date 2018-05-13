<?php

use yii\helpers\Html;
use common\models\User;
use frontend\modules\team\models\Team;
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>

<div class="report_container_item">
	<div class="report_container_inside">
		<div class="report_item_image_container" style="background: url(<?= '/images/reports_thumbnails/'.$model->report->thumbnail.'.jpg' ?>) no-repeat center center; background-size: cover;">
			<?= Html::a($model->report->name, ['/cabinet/view', 'id' => $model->report->id], ['class' => 'report_item_link']) ?>
			<div class="report_item_image_overlay"></div>
		</div>
		<div class="report_item_description_container">
			<?= Html::a($model->report->report_description, ['/cabinet/view', 'id' => $model->report->id], ['class' => 'description_report_text']) ?>
			<div class="report_info_container">
				<div class="created_for_report">
					<?php
						if(!empty($model->team_id)){
							echo Team::getTeamName($model->team_id);
						}elseif(!empty($model->user_id)){
							echo User::getUsersById($model->user_id)[0]->email;
						}
					?>
				</div>
				<div class="created_date_report">
					
				</div>
			</div>
		</div>
	</div>
</div>
