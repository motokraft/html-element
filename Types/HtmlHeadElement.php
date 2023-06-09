<?php namespace Motokraft\HtmlElement\Types;

/**
 * @copyright   2022 motokraft. MIT License
 * @link https://github.com/motokraft/html-element
 */

use \Motokraft\HtmlElement\HtmlElement;

class HtmlHeadElement extends AbstractTypeElement
{
    function __construct(array $attrs = [])
    {
        parent::__construct('head', $attrs);
    }

    function setMeta(array $attrs = []) : HtmlElement
    {
        return $this->appendCreateHtml('meta', $attrs);
    }

    function setBase(array $attrs = []) : HtmlElement
    {
        return $this->appendCreateHtml('base', $attrs);
    }

    function setTitle(string $value) : HtmlElement
    {
        return $this->appendCreateHtml('title', [
            'html' => $value
        ]);
    }

    function setLink(array $attrs = []) : HtmlElement
    {
        return $this->appendCreateHtml('link', $attrs);
    }
}