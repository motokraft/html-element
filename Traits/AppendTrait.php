<?php namespace Motokraft\HtmlElement\Traits;

/**
 * @copyright   2022 motokraft. MIT License
 * @link https://github.com/motokraft/html-element
 */

use \Motokraft\HtmlElement\HtmlElement;

/**
 *
 * Implements an API for appending child elements to the end
 *
 */

trait AppendTrait
{
    /**
     * Adds a string value to the end of child elements
     *
     * @param string $value string value
     * @param bool $escape Removes extra garbage from a string
     *
     * @return HtmlElement Returns the current class instance
     */
    function append(string $result, bool $escape = true) : HtmlElement
	{
        if($escape)
        {
            $result = $this->escape($result);
        }

        array_push($this->childrens, $result);
        return $this;
	}

    /**
     * Adds the HtmlElement class to the end of child elements.
     *
     * @param HtmlElement $element An instance of the class to be appended to the end of child elements
     *
     * @return HtmlElement Returns the passed instance of the HtmlElement class
     */
	function appendHtml(HtmlElement $element) : HtmlElement
	{
        $element->setLevel(($this->level + 1));
        $element->setParent($this);

        array_push($this->childrens, $element);
        return $element;
	}

    /**
     * Creates a new instance of the HtmlElement class and appends it to the end of child elements
     *
     * @param string $type Contains the element's html tag
     * @param array $attrs Contains an array of attributes
     *
     * @return HtmlElement Returns the created instance of the HtmlElement class
     */
    function appendCreateHtml(string $type, array $attrs = []) : HtmlElement
	{
        return $this->appendHtml(new HtmlElement($type, $attrs));
	}
}