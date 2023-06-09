<?php namespace Motokraft\HtmlElement\Types;

/**
 * @copyright   2022 motokraft. MIT License
 * @link https://github.com/motokraft/html-element
 */

use \Motokraft\HtmlElement\HtmlElement;

class HtmlFormElement extends AbstractTypeElement
{
    function __construct(array $attrs = [])
    {
        parent::__construct('form', $attrs);
    }

    function setMethod(string $value) : void
    {
        $this->addAttribute('method', $value);
    }

    function setTarget(string $value) : void
    {
        $this->addAttribute('target', $value);
    }

    function setAction(string $value) : void
    {
        $this->addAttribute('action', $value);
    }

    function setEnctype(string $value) : void
    {
        $this->addAttribute('enctype', $value);
    }

    function setInputHidden(string $name, array $attrs = []) : HtmlElement
    {
        $result = $this->appendCreateHtml('input', $attrs);
        $result->setType('hidden');
        $result->setName($name);

        return $result;
    }
}