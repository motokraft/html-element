<?php namespace Motokraft\HtmlElement\Types;

/**
 * @copyright   2022 motokraft. MIT License
 * @link https://github.com/motokraft/html-element
 */

class HtmlEmbedElement extends AbstractTypeElement
{
    function __construct(array $attrs = [])
    {
        parent::__construct('embed', $attrs);
    }

    function setType(string $value) : void
    {
        $this->addAttribute('type', $value);
    }

    function setSrc(string $value) : void
    {
        $this->addAttribute('src', $value);
    }

    function setWidth(int|string $value) : void
    {
        $this->addAttribute('width', $value);
    }

    function setHeight(int|string $value) : void
    {
        $this->addAttribute('height', $value);
    }

    function setName(string $value) : void
    {
        $this->addAttribute('name', $value);
    }
}