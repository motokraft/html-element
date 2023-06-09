<?php namespace Motokraft\HtmlElement\Types;

/**
 * @copyright   2022 motokraft. MIT License
 * @link https://github.com/motokraft/html-element
 */

class HtmlImageElement extends AbstractTypeElement
{
    function __construct(array $attrs = [])
    {
        parent::__construct('img', $attrs);
    }

    function setSrc(string $value) : void
    {
        $this->addAttribute('src', $value);
    }

    function setAlt(string $value) : void
    {
        $this->addAttribute('alt', $value);
    }

    function setTitle(string $value) : void
    {
        $this->addAttribute('title', $value);
    }

    function setWidth(float|string $value) : void
    {
        $this->addAttribute('width', $value);
    }

    function setHeight(float|string $value) : void
    {
        $this->addAttribute('height', $value);
    }
}