<?php namespace Motokraft\HtmlElement\Types;

/**
 * @copyright   2022 motokraft. MIT License
 * @link https://github.com/motokraft/html-element
 */

class HtmlButtonElement extends AbstractTypeElement
{
    function __construct(array $attrs = [])
    {
        parent::__construct('button', $attrs);
    }

    function setType(string $value) : void
    {
        $this->addAttribute('type', $value);
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
}