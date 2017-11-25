<?php
/**
 * Created by PhpStorm.
 * User: Melle Dijkstra
 * Date: 16-2-2017
 * Time: 15:21
 */
use yii\helpers\Html;

/**
 * DEBUG DIE AND VAR_DUMP anything you give
 * !!!ONLY USE THIS WITH DEVELOPMENT!!!
 * @param $anything mixed Anything you want to vardump
 */
function dd($anything) {
    echo '<pre>';
    var_dump($anything);
    die;
}

/**
 * Shortcut for \yii\helpers\Html::encode($content, $doubleEncode);
 * @see \yii\helpers\Html::decode()
 *
 * @param $content
 * @param bool $doubleEncode
 * @return string
 */
function e($content, $doubleEncode = true) {
    return Html::encode($content, $doubleEncode);
}