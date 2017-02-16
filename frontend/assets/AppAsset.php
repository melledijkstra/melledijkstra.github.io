<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/site.css',
        'css/main.css',
        // Google Font
        'https://fonts.googleapis.com/css?family=Lato',
        'https://fonts.googleapis.com/css?family=Raleway',
        '//cdn.materialdesignicons.com/1.8.36/css/materialdesignicons.min.css',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
