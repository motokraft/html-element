<?php namespace Motokraft\HtmlElement\Attributes;

/**
 * @copyright   2022 motokraft. MIT License
 * @link https://github.com/motokraft/html-element
 */

class BaseAttribute
{
    protected $name;
    protected $value;

    function __construct(string $name, $value)
    {
        $this->setName($name);

        if(isset($value))
        {
            $this->setValue($value);
        }
    }

    function setName(string $name)
    {
        $this->name = $name;
    }

    function setValue($value)
    {
        $this->value = $value;
    }

    function getName()
    {
        return $this->name;
    }

    function getValue()
    {
        return $this->value;
    }

    function render()
    {
        $result = $this->getName();
        $value = $this->getValue();

        if(is_null($value))
        {
            return $result;
        }

        if(strpos($value, '"') !== false)
        {
            $result .= '=\'' . $value . '\'';
        }
        else
        {
            $result .= '="' . $value . '"';
        }

        return $result;
    }

    function __toString()
	{
		return (string) $this->render();
	}
}