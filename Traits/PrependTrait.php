<?php namespace Motokraft\HtmlElement\Traits;

/**
 * @copyright   2022 motokraft. MIT License
 * @link https://github.com/motokraft/html-element
 */

use \Motokraft\HtmlElement\HtmlElement;
use \Motokraft\HtmlElement\HtmlHelper;

/**
 *
 * Implements an API for prepending child elements
 *
 */

trait PrependTrait
{
    /**
     * Adds a string value to the beginning of child elements
     *
     * @param string $value string value
     * @param bool $escape Removes extra garbage from a string
     *
     * @return void
     */
	function prepend(string $result, bool $escape = true) : void
	{
        if($escape) $result = $this->escape($result);
        array_unshift($this->childrens, $result);
	}

    /**
     * Adds the HtmlElement class to the beginning of child elements
     *
     * @param HtmlElement $element An instance of the class to be added to the beginning of child elements
     *
     * @return HtmlElement Returns the passed instance of the HtmlElement class
     */
    function prependHtml(HtmlElement $element) : HtmlElement
	{
        $element->setLevel(($this->level + 1));
        $element->setParent($this);

        array_unshift($this->childrens, $element);
        return $element;
	}

    /**
     * Creates a new instance of the HtmlElement class and appends it to the end of child elements.
     *
     * @param string $type Contains the element's html tag
     * @param array $attrs Contains an array of attributes
     *
     * @return HtmlElement Returns the created instance of the HtmlElement class
     */
    function prependCreateHtml(string $type, array $attrs = []) : HtmlElement
	{
        $result = HtmlHelper::loadTypeClass($type, $attrs);
        return $this->prependHtml($result);
	}
}