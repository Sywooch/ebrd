<?php

namespace frontend\modules\blog\components\widgets\facebookComments;

use Yii;
use yii\base\Widget;
use yii\base\ErrorException;
use yii\base\InvalidParamException;

/**
 * Widget to include the Facebook widget for comments in views.
 *
 * The following example shows how to use CommentsBox:
 *
 * echo CommentsBox::widget([
 *     'appId' => 'MY_FACEBOOK_APP_ID', //defaults to Yii::$app->params['facebook_app_id']
 *     'numPosts' => 10 //defaults to 5
 * ]);
 */
class FacebookComments extends Widget
{
	/*
     * @var string the Facebook application ID needed to authorize their API usage.
     */
    public $appId = null;
	
    /*
     * @var int the number of post to display in every page
     */
	
	public $src = 'https://connect.facebook.net/uk_UA/sdk.js#xfbml=1&version=v3.0';
	
	public $lang = 'uk_UA';

	public $numPosts = 5;
    /**
     * Checks for correct parameters configuration
     */
	
    public function init()
    {
        try{
            $appId = Yii::$app->params['facebook_app_id'];
        }catch (ErrorException $e){
            throw new InvalidParamException('You should define `facebook_app_id` as an application param.');
        }
        $this->appId = $this->appId ?: $appId;
		$this->lang = (Yii::$app->language == 'uk') ? $this->lang : 'en_EN';
		$this->src = 'https://connect.facebook.net/'.$this->lang.'/sdk.js#xfbml=1&version=v3.0';
		
    }
	
    /**
     * @inheritdoc
     * @return string the widget markup
     */
    public function run()
    {
        return $this->render('_comments');
    }
}
