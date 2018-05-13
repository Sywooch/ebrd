<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\file\FileInput;
use yii\bootstrap\Modal;
use common\models\User;

/* @var $this yii\web\View */
/* @var $model frontend\modules\user\models\Profile */
/* @var $subscriptions frontend\modules\user\models\Profile */
/* @var $userSubs common\models\HdbkSubscriptions */
/* @var $form yii\widgets\ActiveForm */

$this->title = Yii::t('user', 'SETTINGS');
Yii::$app->cache->flush();
?>

<p class="cabinet-title"><?= Html::encode($this->title) ?></p>

<div class="cabinet-profile cabinet-profile-settings">

	<?php

	$form = ActiveForm::begin([
		'options'=> ['enctype' => 'multipart/form-data','class' => 'cabinet-profile-settings__container']
	]);
	?>

	<div class="cabinet-profile-settings__container">
		<div class="cabinet-profile__avatar">
			<?php

			echo $form->field($model, 'avatar')->widget(FileInput::classname(), [
				'options' => ['accept' => 'image/*'],
				'pluginOptions' => [
					'allowedFileExtensions' => ['jpg', 'gif', 'png'],
					'previewFileType' => 'image',
					'showPreview' => false,
					'showCaption' => false,
					'showRemove' => false,
					'showUpload' => false,
					'browseClass' => 'btn',
					'browseIcon' => '',
					'browseLabel' =>  '<img id="profile-avatar-img" src="/images/avatars/'.($model->avatar?$model->avatar:'def_avatar.png').'" class="img img-responsive">',
					'initialPreview'=> $model->avatar ? [
						'<img src="/images/avatars/'.$model->avatar.'" class="img img-responsive">',
					] : false,
					'initialCaption'=> Yii::t('user', 'AVATAR'),
				],
			])->label(false);
			?>
		</div>
		<div class="cabinet-profile-settings__box">
			<div class="cabinet-profile-settings__info-item">
				<div class="flex">
					<span>Email: </span>
					<span><?= User::getUserById($model->user_id)->email ?></span>
				</div>

			</div>

			<div class="cabinet-profile-settings__info-item">
				<?= $form->field($model, 'first_name')->textInput(['maxlength' => true])->label(Yii::t('user', 'FIRST_NAME')) ?>
				<?= $form->field($model, 'second_name')->textInput(['maxlength' => true])->label(Yii::t('user', 'SECOND_NAME')) ?>
			</div>
			<div class="cabinet-profile-settings__info-item">
				<?= $form->field($model, 'profession')->textInput(['maxlength' => true])->label(Yii::t('user', 'PROFESSION')) ?>
				<?= $form->field($model, 'city')->textInput(['maxlength' => true])->label(Yii::t('user', 'CITY_COUNTRY')) ?>
			</div>

			<div class="cabinet-profile-settings__info-item">
				<?= $form->field($model, 'phone')->textInput(['maxlength' => true])->label(Yii::t('user', 'PHONE_NUMBER')) ?>
				<?= $form->field($model, 'second_phone')->textInput(['maxlength' => true])->label(Yii::t('user', 'SECOND_PHONE_NUMBER')) ?>

			</div>
		</div>
	</div>

	<div class="cabinet-profile-settings__expertise"><?= $form->field($model, 'biomass_expertise')->textarea(array('rows'=>4,'cols'=>5))->label(Yii::t('user', 'BIOMASS_EXPERTISE')) ?></div>

	<?= Html::submitButton(Yii::t('blog', 'UPDATE'), ['class' => 'button button__ma']) ?>

	<?php
	Modal::begin([
		'header' => '<h2>'.Yii::t('user', 'CHANGE_PASSWORD').'</h2>',
		'id'=>'modal',
		'toggleButton' =>
		[
			'label' => Yii::t('user', 'CHANGE_PASSWORD'),
			'class'=>'cabinet-profile-settings__change-pass button'
		],
		'closeButton' => [
			'id'=>'close-button',
			'data-dismiss' =>'modal',
		],
	]);
	?>

	<div class="change-password">

		<?= $form->field($model, 'old_password', ['errorOptions' => ['class' => 'help-block' ,'encode' => false]])->passwordInput()->label(Yii::t('user', 'OLD_PASSWORD')) ?>
		<?= $form->field($model, 'new_password')->passwordInput()->label(Yii::t('user', 'NEW_PASSWORD')) ?>
		<?= $form->field($model, 'repeat_password')->passwordInput()->label(Yii::t('user', 'REPEAT_PASSWORD')) ?>
	</div>
	<button type="button" class="button button__ma" data-dismiss="modal">Close</button>
	<?php
	Modal::end();
	?>

	<?php ActiveForm::end(); ?>

</div>
<?php
$current_language = Yii::$app->language;
$this->registerJsFile(
	"https://maps.googleapis.com/maps/api/js?key=AIzaSyCk1xu86PPDY4gzg7tYfRvfOfqt5bQR8fk&libraries=places&callback=initAutocomplete&language={$current_language}",
	['position' => $this::POS_END, 'async'=>true, 'defer'=>true]);
	?>

