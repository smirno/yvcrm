<?php

$db = require __DIR__ . '/db.php';

$config = [
    'id' => 'basic-console',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'enableCoreCommands' => false,
    'controllerNamespace' => 'app\commands',
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'log' => [
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db' => $db,
    ]
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    // $config['bootstrap'][] = 'gii';
    // $config['modules']['gii'] = [
    //     'class' => 'yii\gii\Module',
    // ];
}

return $config;
