<?php

$params = require(__DIR__ . '/params.php');

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => '2O-oV9Hf81rAH-FF6_EpEWYxe7o2EoO_',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'common\models\Profiles',
            'enableAutoLogin' => true,
        ],
		
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
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
        'db' => require(__DIR__ . '/db.php'),
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
            ],
        ],
    ],
    'params' => $params,

	//Configure Yii Access for Remote Dev Machine
//	'modules' => [
//		'gii' => [
//			'class' => 'yii\gii\Module',
//			'allowedIPs' => ['127.0.0.1', '::1', '192.168.1.*', '196.201.224.102']
//		],
//	]
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
	    'allowedIPs' => ['127.0.0.1', '::1', '192.168.1.27', '196.201.224.102']
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
	    //Configure Yii Access for Remote Dev Machine
	    'allowedIPs' => ['127.0.0.1', '::1', '192.168.1.27', '196.201.224.102']
    ];
}

return $config;
