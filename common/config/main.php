<?php
return [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'sourceLanguage' => 'en-US',
    'language' => 'en-US',
    // Special modules for this application
    'modules' => [
        'markdown' => [
            'class' => 'kartik\markdown\Module',
        ]
    ],
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

                    ],
                    'on missingTranslations' => ['common\components\TranslationEventHandler', 'handleMissingTranslation'],
                ],
            ],
        ],
    ],
];
