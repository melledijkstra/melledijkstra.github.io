<?php
/**
 * Created by PhpStorm.
 * User: Melle Dijkstra
 * Date: 13-2-2017
 * Time: 16:42
 */

namespace frontend\assets;


use yii\web\AssetBundle;

class MasonryAsset extends AssetBundle
{
    public $js = [
        'https://unpkg.com/masonry-layout@4/dist/masonry.pkgd.min.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
    ];
}