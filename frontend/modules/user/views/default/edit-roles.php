<?php

use yii\helpers\VarDumper;
use yii\helpers\Html;

frontend\modules\user\bundles\UserModuleAsset::register($this);
/* @var $user common\models\User */

?>
<div class="edit_roles_wrap">
	<h1><?= Yii::t('user', 'EDIT_ROLES_FOR_{email}', ['email' => $user->email]) ?></h1>
	<div class="user_info">
		<h2><?= Yii::t('user', 'USER_INFO'); ?></h2>
		<div>id: <?= $user->id ?></div>
		<div>email: <?= $user->email ?></div>
	</div>
	<div class="active_roles">
		<h2><?= Yii::t('user', 'ROLES_ASSIGNED_TO_USER') ?>:</h2>
		<?php
		if (sizeof($userRoles) > 0){
			foreach ($userRoles as $usRole){ ?>
				<div class="active_role_wrap">
					<?= Html::a(
						Yii::t('user', 'REVOKE_ROLE_"{role}"', ['role' => $usRole->name]), 
						['/user/default/revoke-role', 'userId' => $user->id, 'role' => $usRole->name], 
						[
							'class' => 'btn btn-danger',
							'data' => [
								'method' => 'post'
							]
						]); ?>
				</div>
			<div class="role_previleges">
				<?php
				 foreach (Yii::$app->authManager->getPermissionsByRole($usRole->name) as $permission){?>
				<div class="prev_itm"><?= $permission->name ?></div>
				<?php
				 }
				?>
			</div>
			<?php
			} 
		} else { ?>
			<?= Yii::t('user', 'NO_ROLES_ASSIGNED_TO_USER') ?>
		<?php
		}
		?>
	</div>
	<div class="inactive_roles">
		<h2><?= Yii::t('user', 'ROLES_NOT_ASSIGNED_TO_USER') ?>:</h2>
	<?php
	foreach ($allRoles as $role){
		if (!in_array($role, $userRoles)){ ?>
			<div class="inactive_role_wrap">
				<?= Html::a(
					Yii::t('user', 'ASSIGN_ROLE_"{role}"', ['role' => $role->name]),
					['/user/default/assign-role', 'userId' => $user->id, 'role' => $role->name], 
					[
						'class' => 'btn btn-success',
						'data' => [
							'method' => 'post'
						]
					]); ?>
			</div><div class="role_previleges">
			<?php
			 foreach (Yii::$app->authManager->getPermissionsByRole($role->name) as $permission){?>
			<div class="prev_itm"><?= $permission->name ?></div>
			<?php
			 }
			?>
		</div>
	<?php
		}
	}
	?>
	</div>
</div>


<!--<div>User <?= $user->id ?> roles
<?php
//	echo '<pre>';
//	VarDumper::dump($userRoles);
//	echo '</pre>';
?>
</div>

<div>All available roles
<?php
	echo '<pre>';
//	VarDumper::dump(Yii::$app->authManager->getPermissionsByRole($allRoles['admin']->name));
	VarDumper::dump($allRoles);
//	var_dump($allRoles);
	echo '</pre>';
?>
</div>
<div>All available permissions
<?php
//	echo '<pre>';
//	VarDumper::dump($permissions);
//	echo '</pre>';
?>
</div>-->
