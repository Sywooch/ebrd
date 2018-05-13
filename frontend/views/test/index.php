<?php
use Yii;
/* @var $this yii\web\View */
$session = Yii::$app->session;

// get a session variable. The following usages are equivalent:
$language = $session->get('language');
?>
<h1>test/index</h1>

<p>
    You may change the content of this page by modifying
    the file <code><?= __FILE__; ?></code>.
</p>
<?php
		$mail =  Yii::$app->mailer->compose();
		$mail->setFrom([\Yii::$app->params['adminEmail'] => Yii::$app->name])
			->setTo('chesterfield@ukr.net')
			->setSubject(Yii::t('forms', 'FORM_{form_name}_SUBMITTED', ['form_name' => 'name']) . ' at ' . date('Y-m-d H:i'))
			->setHtmlBody('$this->buildMailBody($formData)');
		
		echo $mail->send();
//die();

//use SevenShores\Hubspot\Factory;
//
//$hubspot = new Factory([
//	'key' => '10658b0e-1d8f-4615-8974-26ee1e44bd9d',
//	'oauth' => FALSE,
//	'base_url' => 'https://api.hubapi.com'
//]);
//
//$portal_id = 4009075;
//$form_guid = '19d56011-e938-4571-bcaf-de9a1b9a7128';
//$form = [
//	'email' => 'alexander_simak@gmail.com',
//	'hs_context' => json_encode([
//		'pageName' => 'AIM',
//		'pageUrl'=>'https://aimarketing.info']
//	)];
//$form = $hubspot->forms()->submit($portal_id, $form_guid, $form);


