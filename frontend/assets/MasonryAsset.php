<?php

namespace frontend\assets;


use yii\web\AssetBundle;

class MasonryAsset extends AssetBundle
{
    public $js = [
        '/js/imagesloaded.pkgd.min.js',
        '/js/masonry.pkgd.min.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
    ];
}