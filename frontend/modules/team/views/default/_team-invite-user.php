<?php

use yii\helpers\Html;
use yii\widgets\Pjax;
use yii\widgets\ActiveForm;

rmrevin\yii\fontawesome\AssetBundle::register($this);

Pjax::begin([
	'enablePushState' => FALSE,
	'id' => 'invite_user'
]); ?>
<div class="h_inline">
	<?php if ($model->email) : 
			$displayForm = 'none';
		?>
		<div class="invit_success_wrap" id="invite_success">
			<div class="invit_success_text"><?= Yii::t('user', 'INVITATION_SENT_SUCCESSFULLY') ?></div>
			<?= Html::submitButton(Yii::t('user', 'SEND_ONE_MORE_INVITATION'), [
				'class' => 'btn buttonStd invit_success_btn',
				'id' => 'invite_success_btn',
				'onclick' => '$("#invite_form").show(); $("#invite_success").hide();'
				]) ?>
		</div>

	<?php else : 
		$displayForm = 'block';
	endif; ?>
	<div class="invite_form_wrap" id="invite_form" style="display: <?= $displayForm ?>">	
		<?php $form = ActiveForm::begin([
			'action' => '/team/default/team-invite-user',
			'id' => 'team_invite_user_form',
			'validateOnBlur' => FALSE,
			'options' => [
				// 'class' => 'form-inline',
				'data-pjax' => TRUE
			]
		]); ?>
		
		<div class="invite_flexing">
			<div>
				<?= $form->field($model, 'email', [
					'inputOptions' => [
						'class' => 'form-control',
						'value' => ''
					]
				])->textInput(['placeholder' => Yii::t('blog', 'Enter e-mail')])->label(FALSE) ?>
			</div>
			<div class="form-group">
				<?= Html::submitButton(Yii::t('user', 'INVITE'), [
					'class' => 'btn buttonStd invite_new_user_btn',
					'id' => 'invite_us_btn'
					]) ?>
			</div>
		</div>
			
        <div class="blog_post_col_submit">
		

		<div class="invite_spin" id="ivite_spiner" style="display: none"><i class="fa fa-spinner fa-spin"></i></div>
        </div>
		<?php ActiveForm::end(); ?>
	</div>
</div>
<?php Pjax::end(); ?>