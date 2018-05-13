<?php
namespace frontend\controllers;

use Yii;
use frontend\modules\user\models\Profile;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use common\models\User;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;
use frontend\modules\blog\models\BlogPost;
use frontend\models\HdbkLanguage;
use yii\data\ActiveDataProvider;
use frontend\models\Sitemap;
use frontend\models\HtmlSitemap;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
					[
						'actions' => ['request-password-reset','reset-password','signup','certificate', 'tco-set-password'],
                        'allow' => true,
                        'roles' => ['?','@'],
					],
					[
                        'actions' => ['confirm-email','sitemap','html-sitemap','thanks'],
                        'allow' => true,
                        'roles' => ['@','?'],
                    ],
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
					[
						
                        'actions' => ['login', 'index', 'error', 'auth'],
                        'allow' => true,
                        'roles' => ['?', '@'],
					],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
					[
						'actions' => ['admin'],
						'allow' => true,
						'roles' => ['translate', 'publishItem', 'manageUsers', 'client']
					],
					[
                        'actions' => ['cabinet'],
                        'allow' => true,
                        'roles' => ['client'],
					],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
			'auth' => [
                'class' => 'yii\authclient\AuthAction',
                'successCallback' => [$this, 'onAuthSuccess'],
            ],
        ];
    }
	
	/**
	 * Displays main admin-pannel page
	 * 
	 * @return mixed
	 */
	public function actionAdmin()
	{	
		$model = Yii::$app->user->identity->roles;
		
		if(!empty($model[0]->item_name) && $model[0]->item_name == 'client') {

			return $this->redirect(['/user/cabinet']);
		} 
		$this->layout = 'administrator';
		return $this->render('admin');
	}
	
	public function actionThanks()
	{	
		$this->layout = '/../../views/layouts/empty.php';
		return $this->render('thanks');
	}

	public function actionError()
    {
		$this->layout = 'fullscreen.php';
        $exception = Yii::$app->errorHandler->exception;
		
		$errorNumb = 403;
		
		if (!empty($exception->statusCode)){
			$errorNumb = $exception->statusCode;            
        } elseif (!empty (Yii::$app->response->statusCode)){
            $errorNumb = Yii::$app->response->statusCode;			
		}
		
		return $this->render('errors/' . $errorNumb);
    }

	/**
	 * 
	 * @param type $client
	 * @return mixed authorizes or adds a user through social networks
	 */	
	public function onAuthSuccess($client)
    {
        $attributes = $client->getUserAttributes();
		$service = $client->getId();
		$lang = HdbkLanguage::getLangIdByCode(Yii::$app->language);
		
		$id = $attributes['id'];
		$statusId = '10';

		if($service == 'google') {
			$email = $attributes['emails'][0]['value'];
			$serviceId = 'google_id';
			$name = $attributes['displayName'];
		} 
		
		if ($service == 'facebook') {
			$email = $attributes['email'];
			$serviceId = 'facebook_id';
			$name = $attributes['name'];
		} 
		
		$usersModel = new User();
		
		$auth = $usersModel::find()->where([
			'email' => $email,
		])->one();
		if(!empty($auth)) {
			Yii::$app->user->login($auth);
			return $this->redirect(['/cabinet/blogs']);
		} else {
			if(isset($email)) {
				$registration = new User([
					'email' => $email,
					'status_id' => $statusId,
					$serviceId => $id,
				]);
				
				if ($registration->save()) {
					Profile::createProfileViaSocial($registration->id, $lang, $name);
					Yii::$app->user->login($registration);
					return $this->redirect(['/cabinet/blogs']);
                } else {
                    print_r($registration->getErrors());
                }
			}
		}
    }
	
	/**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
		$this->layout = 'main_new.php';

		$query = BlogPost::find()
				->where([
					'blog_category.alias' => 'main-page',
					'blog_category.lang_id' => HdbkLanguage::getLanguageByCode(Yii::$app->language),
					'blog_post.status_id'	=> BlogPost::STATUS_PUBLISHED,
				])
				->joinWith('category')
				->orderBy('order');
		
		$dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
		
		$openStartProjectForm = FALSE;
		$openStartProjectBrief = FALSE;
		$openClassForm = '';
		if (Yii::$app->request->isGet){
			if (!empty(Yii::$app->request->get()['showForm'])){
				$openStartProjectForm = Yii::$app->request->get()['showForm'];
			}elseif(!empty(Yii::$app->request->get()['showBrief'])){
				$openStartProjectBrief = Yii::$app->request->get()['showBrief'];
			}				
			if(!empty(Yii::$app->request->get()['class'])){
				$openClassForm = Yii::$app->request->get()['class'];
			}
		}

		return $this->render('index', [
			'dataProvider' => $dataProvider,
			'openStartProjectForm' => $openStartProjectForm,
			'openStartProjectBrief' => $openStartProjectBrief,
			'openClassForm' => $openClassForm
        ]);
    }

    /**
     * Logs in a user.
     *
     * @return mixed
     */
    public function actionLogin()
    {
		$this->layout = 'login.php';
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return mixed
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
                Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
            } else {
                Yii::$app->session->setFlash('error', 'There was an error sending your message.');
            }

            return $this->refresh();
        } else {
            return $this->render('contact', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Displays about page.
     *
     * @return mixed
     */
    public function actionAbout()
    {
        return $this->render('about');
    }
	
    /*
    * Confirm user email by reg_token
    * 
    * @param string $token
    * @return mixed
    */
    public function actionConfirmEmail($token)
    {
		$this->layout = '/../../views/layouts/login.php';
		
		if (empty($token) || !is_string($token)) {
			throw new InvalidParamException('Email confirmation token cannot be blank.');
		}
		if (User::confirmEmailByToken($token) && Profile::createProfile()) {
			Yii::$app->session->setFlash('success', 'Email confirmed successfully.');
			return $this->redirect(['/cabinet']);
		}else{
			return $this->redirect(['/login']);
		}
		
		return $this->render('token-invalid');
    }

		/**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionSignup()
    {
        $this->layout = 'login.php';
		User::clearExpiredTokens();
		
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post())) {
			if ($model->signup()) {
				return $this->render('signup-confirm');
            }
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }
	
	public function actionCertificate($certName = false)
    {
		$this->layout = '/../../views/layouts/main.php';
		
		$path = 'images/certificate/';
		
		if(file_exists($path.$certName.'.jpg')){
			return $this->render('certificate', ['link' => '/'.$path.$certName.'.jpg']);
		}elseif(file_exists($path.$certName.'.png')){
			return $this->render('certificate', ['link' => '/'.$path.$certName.'.png']);
		}else{
			throw new \yii\web\HttpException(404);
		}
		
        
    }

    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset()
    {
        $this->layout = 'login.php';
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');

                return $this->goHome();
            } else {
                Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for the provided email address.');
            }
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
		$this->layout = 'login.php';
		
		if(!empty($token)){
			$email = User::getUserByResetToken($token);
		}
		
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }
		
        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
			$model->sendHubspot(Yii::$app->request->post());
			if(empty(Profile::findProfileByUserId(Yii::$app->user->identity->id))){
				Profile::createProfile(Yii::$app->user->identity->id);
			}
            Yii::$app->session->setFlash('success', 'New password saved.');
			$user = Yii::$app->user->identity->roles;
			if(!empty($user[0]->item_name) && $user[0]->item_name == 'client') {
				return $this->redirect(['/cabinet']);
			}
            return $this->redirect(['/login']);
        }

        return $this->render('resetPassword', [
            'model' => $model,
			'email' => $email,
        ]);
    }

		public function actionSitemap()
    {
        $this->layout = 'empty.php';
		Yii::$app->response->format = \yii\web\Response::FORMAT_RAW;
		$headers = Yii::$app->response->headers;
		$headers->add('Content-Type', 'text/xml');
        $html = Sitemap::sitemapGenerator();
        return $this->render('sitemap', ['html' => $html]);
    }
    
    public function actionHtmlSitemap()
    {
        $html = HtmlSitemap::htmlSitemapGenerator();
        return $this->render('html-sitemap', ['html' => $html]);
    }
	
    
    
	public function actionTest()
	{
		$model = User::clearExpiredTokens();
		return $this->render('test', ['model' => $model]);
	}
}
