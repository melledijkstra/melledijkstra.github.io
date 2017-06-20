<?php
/**
 * Created by PhpStorm.
 * User: melle
 * Date: 18-6-2017
 * Time: 18:50
 */

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class P5Asset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $js = [
        'js/p5/p5.js',
        'js/p5/p5.dom.js'
    ];
}