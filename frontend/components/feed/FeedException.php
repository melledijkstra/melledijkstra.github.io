<?php
/**
 * Created by PhpStorm.
 * User: Melle Dijkstra
 * Date: 7-3-2017
 * Time: 17:55
 */

namespace frontend\components\feed;


class FeedException extends \Exception
{
    /**
     * @inheritdoc
     */
    public function __construct($string, $code = 0, \Exception $previous = null)
    {
        parent::__construct($string, $code, $previous);
    }
}