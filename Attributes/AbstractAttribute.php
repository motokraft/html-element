<?php namespace Motokraft\HtmlElement\Attributes;

/**
 * @copyright   2022 motokraft. MIT License
 * @link https://github.com/motokraft/html-element
 */

abstract class AbstractAttribute implements AttributeInterface
{
    private string $_name;

    function __construct(string $name)
    {
        $this->_name = $name;
    }

    function getName() : string
    {
        return $this->_name;
    }

    function render() : string
    {
        $value = $this->getValue();

        if(null === $value)
        {
            return $this->getName();
        }

        $strpos = strpos($value, '"');
        $format = '%s="%s"';

        if($strpos !== false)
        {
            $format = '%s=\'%s\'';
        }

        return vsprintf($format, [
            $this->getName(), $value
        ]);
    }

    function __toString() : string
	{
		return $this->render();
	}
}