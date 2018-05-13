<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-frontend',
	'name'=> 'UBP',
    'basePath' => dirname(__DIR__),
    'bootstrap' => [
		'log',
		'frontend\components\Settings',
		'frontend\modules\blog\components\LanguageSelector',
		'plugins',
		
	],
    'controllerNamespace' => 'frontend\controllers',
    'components' => [
		'authClientCollection' => [
            'class' => 'yii\authclient\Collection',
            'clients' => [
				'facebook' => [
                    'class' => 'yii\authclient\clients\Facebook',
                    'clientId' => '606720173024652',
                    'clientSecret' => '41cea0c74f18295451f0cf854267ec74',
                ],
				'google' => [
                    'class' => 'yii\authclient\clients\Google',
                    'clientId' => '370524488640-77ra39746f767ikt1lqk0remi34ecjnp.apps.googleusercontent.com',
                    'clientSecret' => 'Wl_C-3NIU7y3WqZCaO-WacFw',
                ],
            ],
        ],
        'request' => [
            'csrfParam' => '_csrf-frontend',
            'baseUrl' => '',
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the frontend
            'name' => 'advanced-frontend',
        ],
        'urlManager' => [
			'class' => 'frontend\modules\blog\classes\BlogUrlManager',
            'enablePrettyUrl' => true,
            'showScriptName' => false,
			'normalizer' => [
				'class' => 'yii\web\UrlNormalizer',
				'collapseSlashes' => true,
				'normalizeTrailingSlash' => true,
			],
			'rules' => [
				'search/<q:\d+>' => 'search/search',
				'search' => 'blog/search/search', 
				'news' => 'blog/category/news',
				'contacts' => 'blog/contacts/front-view',
				'sitemap.xml' => 'site/sitemap',
				'sitemap' => 'site/html-sitemap',
				'login' => 'site/login',
				'password-reset' => 'site/request-password-reset',
				'signup' => 'site/signup',
				'cabinet' => 'user/cabinet',
				'cabinet/reports' => 'user/cabinet/reports',
				'cabinet/documents' => 'user/cabinet/documents',
				'cabinet/my-marketing-strategy' => 'user/cabinet/my-marketing-strategy',
				'cabinet/industrial' => 'user/cabinet/industrial',
				'cabinet/nps' => 'user/cabinet/nps',
				'cabinet/geomarketing' => 'user/cabinet/geomarketing',
				'cabinet/manuals' => 'user/cabinet/manuals',
				'cabinet/transfer-pricing' => 'user/cabinet/transfer-pricing',
				'cabinet/view' => 'user/cabinet/view',
				'cabinet/market' => 'user/cabinet/market',
				'cabinet/profile' => 'user/profile',
				'cabinet/profile/settings' => 'user/profile/settings',
				'cabinet/lead-generation' => 'user/cabinet/lead-generation',
                'cabinet/blogs' => 'user/cabinet/blogs',
                'cabinet/events' => 'user/cabinet/events',
                'cabinet/contacts' => 'user/cabinet/contacts',
				'cabinet/team' => 'team/default',
				'certificate/<certName>' => 'site/certificate',
				'/cabinet/partner-bonus' => 'user/partner-bonus',
				'/widget-users' => '/ajax-form-tco/widget-users',
				'/widget-tco' => '/ajax-form-tco/widget-tco',
				'/widget-tco-login' => '/ajax-form-tco/widget-tco-login',
				'catalog/create' => 'catalog/catalog/create',
				'catalog' => 'catalog/catalog',
			],
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-frontend', 'httpOnly' => true],
        ],
        'plugins' => [
			'class' => frontend\modules\plugins\components\PluginsManager::class,
			'appId' => 1, // frontend\modules\plugins\BasePlugin::APP_FRONTEND,
			'enablePlugins' => true,
			'shortcodesParse' => true,
			'shortcodesIgnoreBlocks' => [
					'<pre[^>]*>' => '<\/pre>',
			]
        ],
        'view' => [
			'class' => frontend\modules\plugins\components\View::class,
        ],
		'userDbIp' => [
			'class' => 'frontend\components\geolocation\UserIp',
		],
		'geolocation' => [ 
			'class' => 'frontend\components\geolocation\Geolocation',
			'config' => [
				'provider' => 'geoplugin',
				'return_formats' => 'php',
//				'api_key' => '[YOUR_API_KEY],
			],
		],
	],
    'modules' => [
		'catalog' => [
			'class' => 'frontend\modules\catalog\Catalog',
		],
        'blog' => [
            'class' => 'frontend\modules\blog\Blog',
        ],
        'user' => [
            'class' => 'frontend\modules\user\User',
        ],
        'translation' => [
            'class' => 'frontend\modules\translation\Translation',
        ],
        'plugins' => [
			'class' => 'frontend\modules\plugins\Module',
			'pluginsDir'=>[
				'@frontend/modules/plugins/core', // dir to plugins
				'@frontend/modules/plugins/shortcodes', // dir to shortcodes
			]
        ],
        'forms' => [
                'class' => 'frontend\modules\forms\Module',
        ],
        'gridview' => [
            'class' => 'kartik\grid\Module',
        ],
        'settings' => [
			'class' => 'frontend\modules\settings\Module',
        ],
        'letter' => [
            'class' => 'frontend\modules\letter\Letter',
        ],
		'team' => [
			'class' => 'frontend\modules\team\Module',
		],
        'imagemanager' => [
			'class' => 'noam148\imagemanager\Module',
			'canUploadImage' => function(){
				return Yii::$app->user->can('translate');
			},
			'canRemoveImage' => function(){
				return Yii::$app->user->can('translate');
			},
			'cssFiles' => [
				'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.3/css/font-awesome.min.css',
			],
        ],
    ],
    'params' => $params,
];
