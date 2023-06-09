<?php namespace Motokraft\HtmlElement\Types;

/**
 * @copyright   2022 motokraft. MIT License
 * @link https://github.com/motokraft/html-element
 */

class HtmlBaseElement extends AbstractTypeElement
{
    function __construct(array $attrs = [])
    {
        parent::__construct('base', $attrs);
    }

    function setHref(string $value) : void
    {
        $this->addAttribute('href', $value);
    }

    function setTarget(string $value) : void
    {
        $this->addAttribute('target', $value);
    }
}