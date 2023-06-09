<?php namespace Motokraft\HtmlElement\Attributes;

/**
 * @copyright   2022 motokraft. MIT License
 * @link https://github.com/motokraft/html-element
 */

class StandartAttribute extends AbstractAttribute
{
    private mixed $value = null;

    function __construct(string $name, mixed $value)
    {
        parent::__construct($name);
        
        if(isset($value))
        {
            $this->setValue($value);
        }
    }

    function setValue(mixed $value) : void
    {
        $this->value = $value;
    }

    function getValue() : mixed
    {
        return $this->value;
    }
}