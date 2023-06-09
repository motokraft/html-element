<?php namespace Motokraft\HtmlElement\Styles;

/**
 * @copyright   2022 motokraft. MIT License
 * @link https://github.com/motokraft/html-element
 */

abstract class AbstractStyle
{
    private string $_name;

    function __construct(string $name)
    {
        $this->setName($name);
    }

    function setName(string $name) : void
    {
        $this->_name = $name;
    }

    function getName() : string
    {
        return $this->_name;
    }
}