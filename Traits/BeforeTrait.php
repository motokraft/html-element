<?php namespace Motokraft\HtmlElement\Traits;

/**
 * @copyright   2022 motokraft. MIT License
 * @link https://github.com/motokraft/html-element
 */

use \Motokraft\HtmlElement\HtmlElement;

/**
 *
 * Implements an API to add before an html element
 *
 */

trait BeforeTrait
{
    /**
     * Array of values, before html element
     *
     * @var array<string|HtmlElement>
     */
	private array $before = [];

    /**
     * Adds a string value before an html element
     *
     * @param string $value string value
     * @param bool $escape Removes extra garbage from a string
     *
     * @return HtmlElement Returns the current class instance
     */
    function before(string $value, bool $escape = true) : HtmlElement
	{
        if($escape)
        {
            $value = $this->escape($value);
        }

        array_push($this->before, $value);
        return $this;
	}

    /**
     * Adds the HtmlElement class before the html element
     *
     * @param HtmlElement $element An instance of the class to be added before the html element
     *
     * @return HtmlElement Returns the passed instance of the HtmlElement class
     */
    function beforeHtml(HtmlElement $element) : HtmlElement
	{
        $element->setLevel($this->level);
        $parent = $this->getParent();

        if($parent instanceof HtmlElement)
        {
            $element->setParent($parent);
        }

        array_push($this->before, $element);
        return $element;
	}

    /**
     * Creates a new instance of the HtmlElement class and adds it before the html element
     *
     * @param string $type Contains the element's html tag
     * @param array $attrs Contains an array of attributes
     *
     * @return HtmlElement Returns the created instance of the HtmlElement class
     */
    function beforeCreateHtml(string $type, array $attrs = []) : HtmlElement
	{
        return $this->beforeHtml(new HtmlElement($type, $attrs));
	}
}