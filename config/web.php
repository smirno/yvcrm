<?php

$db = require __DIR__ . '/db.php';

$config = [
    'id' => 'basic',
    'name' => 'YVCRM',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'language' => 'ru-RU',
    // 'language' => 'en-US',
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'components' => [
        'controller' => [
            'class' => 'app\components\extended\Controller',
        ],
        'i18n' => [
            'class' => 'app\components\extended\I18N',
            'translations' => [
                'app' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'sourceLanguage' => 'en-US',
                    'basePath' => '@app/translations'
                ]
            ]

        ],
        'assetManager' => [
            'appendTimestamp' => true,
        ],
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'Z3diMBkKSq6o3iBYfuxMa98HyQz7Oogc',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
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
        'db' => $db,
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                'leads/<id>' => 'leads/lead',
                'login' => 'site/login',
                'app' => 'app',
                'app/dashboard' => 'app',
                'app/contacts' => 'contacts',
                'app/contacts/filters' => 'contacts/filters',
                'app/contacts/<id>' => 'contact',
                'app/leads' => 'leads',
                'app/leads/<id>' => 'lead',
            ],
        ],
        
    ]
];

define('DS', DIRECTORY_SEPARATOR);

if (YII_DEBUG) {
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
    ];
}

return $config;
