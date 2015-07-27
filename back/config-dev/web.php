<?php

$params = require(__DIR__ . '/params.php');

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
	'defaultRoute' => 'index',
	'layout' => false,
    'components' => [
    	'urlManager' => [
    			'enablePrettyUrl' => true,
    			// 'enableStrictParsing' => true,
    			'showScriptName' => false,
    				'rules' => [
    					"<controller:\w+>/<action:\w+>"=>"<controller>/<action>",
    			]
    	],
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'social-open',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
//         'user' => [
//             'identityClass' => 'app\models\User',
//             'enableAutoLogin' => true,
//         ],
//         'errorHandler' => [
//             'errorAction' => 'site/error',
//         ],
//         'mailer' => [
//             'class' => 'yii\swiftmailer\Mailer',
//             // send all mails to a file by default. You have to set
//             // 'useFileTransport' to false and configure a transport
//             // for the mailer to send real emails.
//             'useFileTransport' => true,
//         ],
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
    ],
    'params' => $params,
];

return $config;
