<?php
return [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'assetManager' => [
            'class' => 'yii\web\AssetManager',
            'appendTimestamp' => true,
        ],
	'authManager' => [
            'class' => 'yii\rbac\DbManager',
        ],
        'i18n' => [
			'translations' => [
				'*' => [
					'class' => 'yii\i18n\DbMessageSource',
					'enableCaching' => true,
					'cache' => 'cache',
					'cachingDuration' => 3600,
				],
			],
		],
		'imagemanager' => [
			'class' => 'noam148\imagemanager\components\ImageManagerGetPath',
			//set media path (outside the web folder is possible)
			'mediaPath' => 'upload',
			//path relative web folder to store the cache images
			'cachePath' => 'assets/images',
			//use filename (seo friendly) for resized images else use a hash
			'useFilename' => true,
			//show full url (for example in case of a API)
			'absoluteUrl' => false,
		],
    ],
];
