<?php namespace Motokraft\HtmlElement\Types;

/**
 * @copyright   2022 motokraft. MIT License
 * @link https://github.com/motokraft/html-element
 */

class HtmlInputElement extends AbstractTypeElement
{
    function __construct(array $attrs = [])
    {
        parent::__construct('input', $attrs);
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

    function setRequired(bool $value) : void
    {
        if($value)
        {
            $this->addAttribute('required');
        }
        else
        {
            $this->removeAttribute('required');
        }
    }

    function setChecked(bool $value) : void
    {
        if($value)
        {
            $this->addAttribute('checked');
        }
        else
        {
            $this->removeAttribute('checked');
        }
    }

    function setMultiple(string $value) : void
    {
        $this->addAttribute('multiple', $value);
    }

    function setName(string $value) : void
    {
        $this->addAttribute('name', $value);
    }

    function setStep(float|int $value) : void
    {
        $this->addAttribute('step', $value);
    }

    function setValue(mixed $value) : void
    {
        $this->addAttribute('value', $value);
    }
}