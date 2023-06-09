<?php namespace Motokraft\HtmlElement\Types;

/**
 * @copyright   2022 motokraft. MIT License
 * @link https://github.com/motokraft/html-element
 */

use \Motokraft\HtmlElement\HtmlElement;

class HtmlMetaElement extends AbstractTypeElement
{
    function __construct(array $attrs = [])
    {
        parent::__construct('meta', $attrs);
    }

    function setCharset(string $value) : void
    {
        $this->addAttribute('charset', $value);
    }

    function setContent(string $value) : void
    {
        $this->addAttribute('content', $value);
    }

    function setHttpEquiv(string $value) : void
    {
        $this->addAttribute('httpEquiv', $value);
    }

    function setMedia(string $value) : void
    {
        $this->addAttribute('media', $value);
    }

    function setName(string $value) : void
    {
        $this->addAttribute('name', $value);
    }
}