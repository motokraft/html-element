<?php namespace Motokraft\HtmlElement\Types;

/**
 * @copyright   2022 motokraft. MIT License
 * @link https://github.com/motokraft/html-element
 */

use \Motokraft\HtmlElement\HtmlElement;

abstract class AbstractTypeElement extends HtmlElement
{
    function setType(string $type) : void
    {
        throw new \Exception('It is forbidden to change the elements HTML tag', 500);
    }
}