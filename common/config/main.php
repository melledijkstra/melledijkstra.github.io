<?php
return [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
        ],
        // All configuration for authentication
        'authManager' => [
            'class' => 'yii\rbac\DbManager'
        ],
        // Disable caching assets in debug mode
        'assetManager' => [
            'forceCopy' => YII_DEBUG
        ],
        'i18n' => [
            'translations' => [
                '*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@common/translations',
                    'fileMap' => [
                        'app' => 'app.php',
                        'common' => 'common.php',
                        /** Models */
                        'guide' => 'guide.php',
                    ],
                ],
            ],
        ],
    ],
];
