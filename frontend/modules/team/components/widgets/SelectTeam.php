<?php

namespace frontend\modules\team\components\widgets;

use yii\base\Widget;
use frontend\modules\team\models\Team;
use kartik\select2\Select2;
use Yii;

class SelectTeam extends Widget
{
	public function init(){
		parent::init();
	}
	
	public function run() {
		if(Yii::$app->user->can('manageUsers')){
			$teams = Team::userSuperAdmin();
		}else{
			$teams = Team::userAdmin();
		}
		
		if (sizeof($teams) == 0){
			$res = '';
		} else {
			$dataTeams = [];
			foreach ($teams as $team){
				$dataTeams[$team->id] = $team->name;
			}
			$res = Select2::widget([
				'name' => 'status',
				'hideSearch' => false,
				'data' => $dataTeams,
				'theme' => 'bootstrap',
				'options' => ['placeholder' => Yii::t('blog', 'SELECT_TEAM')],
				'pluginOptions' => [
					'allowClear' => true
				],
				'pluginEvents' => [
					"change" => "function() {
						$(this).children(':selected').each(function(){
							window.location.href = '/team/default/select-team?id='+$(this).val();
						});
					}",
				],
			]);
		}
		return $res;
	}
}
