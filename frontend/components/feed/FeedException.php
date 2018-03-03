<?php

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