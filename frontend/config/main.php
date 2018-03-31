<?php

use common\models\User;
use yii\log\FileTarget;

$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'frontend\controllers',
    'defaultRoute' => '/site/resume',
    'components' => [
        'assetManager' => YII_ENV_PROD ? [
            'bundles' => require __DIR__ . '/assets-compressed.php',
        ] : [],
        'request' => [
            'csrfParam' => '_csrf-frontend',
        ],
        'user' => [
            'identityClass' => User::class,
            'enableAutoLogin' => true,
            'identityCookie' => [
                'name' => '_identity-frontend',
                'httpOnly' => true
            ],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the frontend
            'name' => 'advanced-session',
            'cookieParams' => [
                'domain' => '.dev.local'
            ],
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => FileTarget::class,
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'urlManager' => [
            'rules' => [
                '<alias:resume>' => 'site/<alias>',
                '<controller>' => '<controller>/index',
                'guides/<title:\S*>'    => 'guides/view',
                'portfolio/<title:\S*>'  => 'portfolio/view',
            ],
        ],
    ],
    'params' => $params,
];
