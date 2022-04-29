<?php namespace Motokraft\HtmlElement\Object;

/**
 * @copyright   2022 motokraft. MIT License
 * @link https://github.com/motokraft/html-element
 */

use \Motokraft\Object\BaseObject;

class Attributes extends BaseObject
{
    function __construct(array $data)
    {
        $this->loadArray($data);
    }
}