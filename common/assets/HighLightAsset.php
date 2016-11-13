<?php
/**
 * Created by PhpStorm.
 * User: melle
 * Date: 13-11-2016
 * Time: 22:12
 */

namespace common\assets;


use yii\web\AssetBundle;

class HighLightAsset extends AssetBundle
{

    public $basePath = '@webroot';
    public $baseUrl = '@web';

    public $js = [ '//cdnjs.cloudflare.com/ajax/libs/highlight.js/9.8.0/highlight.min.js' ];
    public $css = [ '//cdnjs.cloudflare.com/ajax/libs/highlight.js/9.8.0/styles/darcula.min.css' ];

}