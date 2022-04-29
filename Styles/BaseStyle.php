<?php namespace Motokraft\HtmlElement\Styles;

/**
 * @copyright   2022 motokraft. MIT License
 * @link https://github.com/motokraft/html-element
 */

class BaseStyle
{
    private $name;
    private $value;
    private $important;

    function __construct(?string $value = null)
    {
        $this->setValue($value);
    }

    function setName(string $name)
    {
        $this->name = $name;
    }

    function setValue($value)
    {
        $this->value = $value;
    }

    function setImportant($value)
    {
        $this->important = $value;
    }

    function getName()
    {
        return $this->name;
    }

    function getValue()
    {
        return $this->value;
    }

    function getImportant()
    {
        return $this->important;
    }

    function render()
    {
        $result = $this->getName() . ': ';
        $result .= $this->getValue();

        if((bool) $this->getImportant())
        {
            $result .= ' !important';
        }

        return $result . ';';
    }

    function __toString()
	{
		return (string) $this->render();
	}
}