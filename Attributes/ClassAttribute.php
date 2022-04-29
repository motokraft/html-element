<?php namespace Motokraft\HtmlElement\Attributes;

/**
 * @copyright   2022 motokraft. MIT License
 * @link https://github.com/motokraft/html-element
 */

class ClassAttribute extends BaseAttribute
{
    protected $name;
    protected $value = [];

    function setValues(array $values)
    {
        $this->value = array_merge($this->value, $values);
    }

    function setValue($value)
    {
        if(!in_array($value, $this->value))
        {
            array_push($this->value, $value);
            return true;
        }

        return false;
    }

    function getValue()
    {
        return implode(' ', $this->value);
    }

    function removeValue(string $value)
    {
        if(!$this->hasValue($value))
        {
            return false;
        }

        $key = array_search($value, $this->value);
        echo $key . ' | ' . $value . "\n";

        unset($this->value[$key]);

        return true;
    }

    function hasValue(string $value)
    {
        return in_array($value, $this->value);
    }
}