<?php
/**
 * Created by PhpStorm.
 * User: Melle Dijkstra
 * Date: 16-2-2017
 * Time: 15:21
 */

/**
 * DEBUG DIE AND VAR_DUMP anything you give
 * @param $anything mixed Anything you want to vardump
 */
function dd($anything) {
    echo '<pre>';
    var_dump($anything);
    die();
}