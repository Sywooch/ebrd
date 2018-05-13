<?php

namespace frontend\components;

use frontend\models\HdbkLanguage;
use frontend\modules\plugins\models\PluginsAutolinkerGlobalSettings;
use Yii;

class Settings implements \yii\base\BootstrapInterface
{
	public function bootstrap($app) {
		$app->params['settings']['activeLangsObjs']		= HdbkLanguage::getLanguagesSymbols();
		$app->params['settings']['activeLangsKeyValue']	= HdbkLanguage::getLanguagesKeyValue();
		$app->params['settings']['defaultLangObj']		= HdbkLanguage::getDefaultLanguage();
		$app->params['settings']['supportedLanguages']	= HdbkLanguage::getLanguagesSymbolsArray();
		$app->params['settings']['defaultLanguage']		= HdbkLanguage::getDefaultLanguageCode();
		$app->params['settings']['defaultLanguageId']	= HdbkLanguage::getDefaultLanguageId();
		
		$app->params['settings']['globalAutolinkerSettings']	= PluginsAutolinkerGlobalSettings::getGlobalSettings();
                
		$app->params['settings']['mainPageTitle']	= \frontend\modules\settings\models\Settings::findOne(['name' => 'mainPageTitle'])->value;
        $app->params['settings']['mainPageDescription']	= \frontend\modules\settings\models\Settings::findOne(['name' => 'mainPageDescription'])->value;

		$app->name = Yii::t('settings',\frontend\modules\settings\models\Settings::findOne(['name' => 'siteName'])->value);
		
		$sign_en = '<table style="clear: both;">';
        $sign_en .= '<tbody>';
        $sign_en .= '    <tr>';
        $sign_en .= '        <td style="height:30px"> </td>';
        $sign_en .= '        <td> </td>';
        $sign_en .= '    </tr>';
        $sign_en .= '    <tr> </tr>';
        $sign_en .= '</tbody>';
		$sign_en .= '</table>';
		$sign_en .= '<table class="pad1" style="box-sizing:border-box;float:left;display:inline-block;vertical-align:top;padding-right: 20px;">';
		$sign_en .= '   <tbody>';
		$sign_en .= '       <tr>';
		$sign_en .= '           <td valign="top" class="onest" style="padding-right:10px;"><img title="Yuriy Shchyrin" alt="Yuriy Shchyrin" src="https://aimarketing.info/images/mail/photos/yuriy.png"> </td>';
		$sign_en .= '           <td class="text1" valign="top" style="line-height:16px;color:#ac162c;font-size:14px;padding-left:0;font-weight:normal;font-family: arial, serif;">';
		$sign_en .= '              <span style="font-size:14px;font-weight:bold;line-height:16px;margin-left:0px;margin-right:0px;margin-top:0px;margin-bottom:0px;padding:0px;">Kind regards,</span><br><span style="font-size:13px;">Yuriy Shchyrin</span><br><span style="font-size:11px;">Chairman</span><br><br><a style="font-size:11px;display:inline-block; background: #ac162c; color:#fff; text-decoration: none;" href="https://app.hubspot.com/meetings/yuriy-shchyrin" target="_blank"><span style="padding: 6px 6px;display:inline-block;">Book some time with me</span></a></td>';
		$sign_en .= '       </tr>';
		$sign_en .= '   </tbody>';
		$sign_en .= '</table>';
		$sign_en .= '<table class="pad3" style="box-sizing:border-box;float:left;display:inline-block;vertical-align:top;">';
		$sign_en .= '    <tbody>';
		$sign_en .= '       <tr>';
		$sign_en .= '           <td valign="top" style="font-size:12px;vertical-align:top;font-family: Arial, serif;line-height:17px;color:#ac162c;padding-right:20px;">';
		$sign_en .= '               <a href="https://aimarketing.info/" target="_blank"><img title="www.aimarketing.info" alt="www.aimarketing.info" src="https://aimarketing.info/images/mail/aim_logo.jpg"></a><br>';
		$sign_en .= '               <span style="font-size:14px;font-weight:bold;line-height:16px;margin-left:0px;margin-right:0px;margin-top:0px;margin-bottom:0px;padding:0px;font-size:14px;">Agency of Industrial Marketing</span><br> Your industrys best fit <br>Americas, EMEA, Asia-Pacific<br> </td>';
		$sign_en .= '          <td valign="top" style="font-size:12px;vertical-align:top;font-family: Arial, serif;line-height:13px;color:#ac162c;">';
		$sign_en .= '              <span style="font-size:14px;font-weight:bold;line-height:16px;margin-left:0px;margin-right:0px;margin-top:0px;margin-bottom:0px;padding:0px;font-size:14px;">Head office:</span><br> 3 Sholudenka str., office 310 <br>Kyiv, Ukraine, 04116, <br>tel: <a style="text-decoration:none;color:#ac162c;" href="tel:+380442909435">+380442909435</a><br>mob: <a style="text-decoration:none;color:#ac162c;" href="tel:+380504411474">+380504411474</a><br><a style="text-decoration:none;color:#ac162c;" href="http://www.aimarketing.info" target="_blank">www.aimarketing.info</a><br><br>';
		$sign_en .= '             <span style="font-weight:bold;line-height:0;margin-left:0px;margin-right:0px;margin-top:0px;margin-bottom:0px;padding: 8px 0;">';
		$sign_en .= '                  <a style="text-decoration:none;color:#fff;" href="https://www.linkedin.com/company/768688/" target="_blank"> <img src="https://aimarketing.info/images/mail/aim_linkedin.png" title="Linkedin" alt="Linkedin"> </a>';
		$sign_en .= '                  <a style="text-decoration:none;color:#fff;" href="https://www.facebook.com/aimarketing.info/" target="_blank"> <img style="margin-left:5px" src="https://aimarketing.info/images/mail/aim_facebook.png" title="Facebook" alt="Facebook"> </a>';
		$sign_en .= '                  <a style="text-decoration:none;color:#fff;" href="https://www.youtube.com/channel/UC7mpOXonmHTV4yaNZyAMgpg" target="_blank"> <img style="margin-left:5px" src="https://aimarketing.info/images/mail/aim_youtube.png" title="YouTube" alt="YouTube"> </a>';
		$sign_en .= '              </span><br>';
		$sign_en .= '           </td>';
		$sign_en .= '       </tr>';
		$sign_en .= '   </tbody>';
		$sign_en .= ' </table>';
		$sign_en .= ' <table style="clear: both;">';
		$sign_en .= '    <tbody>';
		$sign_en .= '        <tr>';
		$sign_en .= '           <td style="height:30px"> </td>';
		$sign_en .= '            <td> </td>';
		$sign_en .= '        </tr>';
		$sign_en .= '       <tr> </tr>';
		$sign_en .= '    </tbody>';
		$sign_en .= '</table>';
		$app->params['settings']['sing_en'] = $sign_en;
		
		$sign_uk = '<table style="clear: both;">';
        $sign_uk .= '<tbody>';
        $sign_uk .= '    <tr>';
        $sign_uk .= '        <td style="height:30px"> </td>';
        $sign_uk .= '        <td> </td>';
        $sign_uk .= '    </tr>';
        $sign_uk .= '    <tr> </tr>';
        $sign_uk .= '</tbody>';
		$sign_uk .= '</table>';
		$sign_uk .= '<table class="pad1" style="box-sizing:border-box;float:left;display:inline-block;vertical-align:top;padding-right: 20px;">';
		$sign_uk .= '   <tbody>';
		$sign_uk .= '       <tr>';
		$sign_uk .= '           <td valign="top" class="onest" style="padding-right:10px;"><img title="Yuriy Shchyrin" alt="Yuriy Shchyrin" src="https://aimarketing.info/images/mail/photos/yuriy.png"> </td>';
		$sign_uk .= '           <td class="text1" valign="top" style="line-height:16px;color:#ac162c;font-size:14px;padding-left:0;font-weight:normal;font-family: arial, serif;">';
		$sign_uk .= '              <span style="font-size:14px;font-weight:bold;line-height:16px;margin-left:0px;margin-right:0px;margin-top:0px;margin-bottom:0px;padding:0px;">Kind regards,</span><br><span style="font-size:13px;">Yuriy Shchyrin</span><br><span style="font-size:11px;">Chairman</span><br><br><a style="font-size:11px;display:inline-block; background: #ac162c; color:#fff; text-decoration: none;" href="https://app.hubspot.com/meetings/yuriy-shchyrin" target="_blank"><span style="padding: 6px 6px;display:inline-block;">Book some time with me</span></a></td>';
		$sign_uk .= '       </tr>';
		$sign_uk .= '   </tbody>';
		$sign_uk .= '</table>';
		$sign_uk .= '<table class="pad3" style="box-sizing:border-box;float:left;display:inline-block;vertical-align:top;">';
		$sign_uk .= '    <tbody>';
		$sign_uk .= '       <tr>';
		$sign_uk .= '           <td valign="top" style="font-size:12px;vertical-align:top;font-family: Arial, serif;line-height:17px;color:#ac162c;padding-right:20px;">';
		$sign_uk .= '               <a href="https://aimarketing.info/" target="_blank"><img title="www.aimarketing.info" alt="www.aimarketing.info" src="https://aimarketing.info/images/mail/aim_logo.jpg"></a><br>';
		$sign_uk .= '               <span style="font-size:14px;font-weight:bold;line-height:16px;margin-left:0px;margin-right:0px;margin-top:0px;margin-bottom:0px;padding:0px;font-size:14px;">Agency of Industrial Marketing</span><br> Your industrys best fit <br>Americas, EMEA, Asia-Pacific<br> </td>';
		$sign_uk .= '          <td valign="top" style="font-size:12px;vertical-align:top;font-family: Arial, serif;line-height:13px;color:#ac162c;">';
		$sign_uk .= '              <span style="font-size:14px;font-weight:bold;line-height:16px;margin-left:0px;margin-right:0px;margin-top:0px;margin-bottom:0px;padding:0px;font-size:14px;">Head office:</span><br> 3 Sholudenka str., office 310 <br>Kyiv, Ukraine, 04116, <br>tel: <a style="text-decoration:none;color:#ac162c;" href="tel:+380442909435">+380442909435</a><br>mob: <a style="text-decoration:none;color:#ac162c;" href="tel:+380504411474">+380504411474</a><br><a style="text-decoration:none;color:#ac162c;" href="http://www.aimarketing.info" target="_blank">www.aimarketing.info</a><br><br>';
		$sign_uk .= '             <span style="font-weight:bold;line-height:0;margin-left:0px;margin-right:0px;margin-top:0px;margin-bottom:0px;padding: 8px 0;">';
		$sign_uk .= '                  <a style="text-decoration:none;color:#fff;" href="https://www.linkedin.com/company/768688/" target="_blank"> <img src="https://aimarketing.info/images/mail/aim_linkedin.png" title="Linkedin" alt="Linkedin"> </a>';
		$sign_uk .= '                  <a style="text-decoration:none;color:#fff;" href="https://www.facebook.com/aimarketing.info/" target="_blank"> <img style="margin-left:5px" src="https://aimarketing.info/images/mail/aim_facebook.png" title="Facebook" alt="Facebook"> </a>';
		$sign_uk .= '                  <a style="text-decoration:none;color:#fff;" href="https://www.youtube.com/channel/UC7mpOXonmHTV4yaNZyAMgpg" target="_blank"> <img style="margin-left:5px" src="https://aimarketing.info/images/mail/aim_youtube.png" title="YouTube" alt="YouTube"> </a>';
		$sign_uk .= '              </span><br>';
		$sign_uk .= '           </td>';
		$sign_uk .= '       </tr>';
		$sign_uk .= '   </tbody>';
		$sign_uk .= ' </table>';
		$sign_uk .= ' <table style="clear: both;">';
		$sign_uk .= '    <tbody>';
		$sign_uk .= '        <tr>';
		$sign_uk .= '           <td style="height:30px"> </td>';
		$sign_uk .= '            <td> </td>';
		$sign_uk .= '        </tr>';
		$sign_uk .= '       <tr> </tr>';
		$sign_uk .= '    </tbody>';
		$sign_uk .= '</table>';
		$app->params['settings']['sing_uk'] = $sign_uk;
                
	}
}
