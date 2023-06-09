<?php namespace Motokraft\HtmlElement\Styles;

/**
 * @copyright   2022 motokraft. MIT License
 * @link https://github.com/motokraft/html-element
 */

class StandartStyle extends AbstractStyle
{
    private mixed $value;
    private bool $important = false;

    function setValue(mixed $value) : void
    {
        $this->value = $value;
    }

    function setImportant(bool $value) : void
    {
        $this->important = $value;
    }

    function getValue() : mixed
    {
        return $this->value;
    }

    function getImportant() : bool
    {
        return $this->important;
    }

    function __toString() : string
	{
		$value = $this->getValue();

        if((bool) $this->important)
        {
            $value .= ' !important';
        }

        return vsprintf('%s: %s;', [
            $this->getName(), $value
        ]);
	}
}