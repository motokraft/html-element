<?php namespace Motokraft\HtmlElement\Types;

/**
 * @copyright   2022 motokraft. MIT License
 * @link https://github.com/motokraft/html-element
 */

use \Motokraft\HtmlElement\HtmlElement;

class HtmlFieldSetElement extends AbstractTypeElement
{
    function __construct(array $attrs = [])
    {
        parent::__construct('fieldset', $attrs);
    }

    function setLegend(string $html, bool $escape = true) : HtmlElement
    {
        $result = $this->appendCreateHtml('legend');
        $result->html($html, $escape);

        return $result;
    }

    function setDisabled(bool $value) : void
    {
        if($value)
        {
            $this->addAttribute('disabled');
        }
        else
        {
            $this->removeAttribute('disabled');
        }
    }

    function setName(string $value) : void
    {
        $this->addAttribute('name', $value);
    }
}