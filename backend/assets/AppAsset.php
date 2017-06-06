<?php

namespace backend\assets;

use yii\web\AssetBundle;

/**
 * Main backend application asset bundle.
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
        '//cdn.materialdesignicons.com/1.8.36/css/materialdesignicons.min.css',
    ];
    public $js = [
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];

    /**
     * @inheritDoc
     */
    public function init()
    {
        // add dynamic css from frontend
        $this->css[] = \Yii::$app->params['frontendUrl'].'/css/main.css';
        parent::init();
    }


}
