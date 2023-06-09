<?php namespace Motokraft\HtmlElement\Attributes;

/**
 * @copyright   2022 motokraft. MIT License
 * @link https://github.com/motokraft/html-element
 */

class ClassAttribute extends AbstractAttribute
{
    private array $value = [];

    function __construct(string $name, mixed $value)
    {
        parent::__construct($name);

        if(isset($value))
        {
            $this->setValue($value);
        }
    }

    function setValues(array $values) : void
    {
        foreach($values as $value)
        {
            if($this->hasValue($value))
            {
                continue;
            }

            $this->setValue($value);
        }
    }

    function setValue(mixed $value) : void
    {
        array_push($this->value, $value);
    }

    function getValues() : array
    {
        return $this->value;
    }

    function getValue() : string
    {
        return implode(' ', $this->value);
    }

    function removeValue(mixed $value) : bool
    {
        if(!$this->hasValue($value))
        {
            return false;
        }

        $data = (array) $this->getValues();
        $index = array_search($value, $data);

        unset($this->value[$index]);
        return true;
    }

    function hasValue(mixed $value) : bool
    {
        return in_array($value, $this->value);
    }
}