<?php
return [
    'name' => 'Melle Dijkstra',
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'language' => 'en-US',
    'sourceLanguage' => 'en-US',
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
        'formatter' => [
            'class' => \yii\i18n\Formatter::className(),
            'dateFormat'        => 'dd-MM-yyyy',
            'datetimeFormat'    => 'dd-MM-yyyy hh:mm:ss',
            'timeFormat'        => 'hh:mm:ss',
            'decimalSeparator'  => ',',
            'thousandSeparator' => '.',
            'currencyCode'      => 'EUR',
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
                    'on missingTranslation' => ['common\components\TranslationEventHandler', 'handleMissingTranslation'],
                ],
                // This isn't included with the * translations, weird yii behaviour, so need to create separate 'app' part in translations
                'app' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@common/translations',
                    'on missingTranslation' => ['common\components\TranslationEventHandler', 'handleMissingTranslation'],
                ]
            ],
        ],
    ],
];
