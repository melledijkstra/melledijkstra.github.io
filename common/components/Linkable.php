<?php
/**
 * Created by PhpStorm.
 * User: Melle Dijkstra
 * Date: 12-2-2017
 * Time: 00:44
 */

namespace common\components;

/**
 * When implementing this interface you need to specify where this resource can be found and it means
 * you can link to the resource
 * Interface Linkable
 * @package common\components
 */
interface Linkable
{
    /**
     * Specify the link where this resource can be found
     * @param bool $absolute If the link has to be an absolute url
     * @return string
     */
    public function getLink($absolute = false): string;
}