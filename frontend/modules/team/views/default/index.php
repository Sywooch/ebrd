<?php
use frontend\modules\team\components\widgets\SelectTeam;
use frontend\modules\team\models\Team;
use yii\helpers\Html;
use common\models\Invitation;
/* @var $this yii\web\View */
$this->title = Yii::t('blog', 'TEAM');
?>
<div class="main_block_class">
	<span class="main_action_title"><?= Html::encode($this->title) ?></span>
</div>
<div class="team_wrap">
	<div class="team_controls">
		<?php if(Yii::$app->user->can('manageUsers')){ ?>
			<div class="main_action_class create_team_alert" ><?= (Yii::$app->user->can('manageUsers')) ? Html::a(Yii::t('blog', 'CREATE_TEAM'), ['/team/default/create'], ['class' => 'btn btn-success']) : ''?></div>
		<?php } ?>
		<?php
			if((sizeof(Invitation::getUserTeams()) > 1) || Yii::$app->user->can('manageUsers')){
				echo SelectTeam::widget();
			}
		?>
	</div>
	<div class="tm_box name">
		<div class="val name_form">
			<?php 
				if(Yii::$app->user->can('manageUsers')){
					echo $this->render('_team-set-name', ['model' => $modelTeamName]);
				}else{
					echo '<div class="team_name_style">'.Yii::$app->user->identity->profile->currentTeam->name.'</div>';
				}
			?>
		</div>
	</div>
	<?php if(!empty(Team::userIsAdmin())){ ?>
		<div class="tm_box invite">
			<div class="val invite_form">
				<?= $this->render('_team-invite-user', ['model' =>  $modelInviteUser])?>
			</div>
		</div>
	<?php } ?>
	<div class="membs_container">
		<div class="tm_box membs" id="tm_box_memb_div">
			<div class="val members">
				<?= $this->render('_team-table', ['model' =>  $teamTableDP])?>
			</div>
		</div>	
	</div>
</div>