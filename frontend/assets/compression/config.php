<?php use yii\web\AssetBundle;

/**
 * Configuration file for the "yii asset" console command.
 */

// In the console environment, some path aliases may not exist. Please define these:
Yii::setAlias('@webroot', __DIR__ . '/../../web');
Yii::setAlias('@web', '/');

return [
    // Adjust command/callback for JavaScript files compressing:
    'jsCompressor' => 'java -jar frontend/assets/compression/compiler.jar --js {from} --js_output_file {to}',
    // Adjust command/callback for CSS files compressing:
    'cssCompressor' => 'java -jar frontend/assets/compression/yuicompressor-2.4.2.jar --type css {from} -o {to}',
    // Whether to delete asset source after compression:
    'deleteSource' => false,
    // The list of asset bundles to compress:
    'bundles' => [
        \frontend\assets\AppAsset::className(),
        \yii\web\YiiAsset::className(),
        \yii\web\JqueryAsset::className(),
        \yii\bootstrap\BootstrapAsset::className(),
        \yii\widgets\PjaxAsset::className(),
        \yii\validators\ValidationAsset::className(),
        \yii\widgets\ActiveFormAsset::className(),
    ],
    // Asset bundle for compression output:
    'targets' => [
        'all' => [
            'class' => AssetBundle::class,
            'basePath' => '@webroot',
            'baseUrl' => '@web',
            'js' => 'compiled-assets/all-{hash}.js',
            'css' => 'compiled-assets/all-{hash}.css',
        ],
    ],
    // Asset manager configuration:
    'assetManager' => [
        'basePath' => '@webroot/assets',
        'baseUrl' => '@web/assets',
    ],
];