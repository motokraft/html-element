<?php namespace Motokraft\HtmlElement\Types;

/**
 * @copyright   2022 motokraft. MIT License
 * @link https://github.com/motokraft/html-element
 */

class HtmlLinkElement extends AbstractTypeElement
{
    function __construct(array $attrs = [])
    {
        parent::__construct('link', $attrs);
    }

    function setHref(string $value) : void
    {
        $this->addAttribute('href', $value);
    }

    function setRel(string $value) : void
    {
        $this->addAttribute('rel', $value);
    }
}