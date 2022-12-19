<?php namespace Motokraft\HtmlElement\Traits;

/**
 * @copyright   2022 motokraft. MIT License
 * @link https://github.com/motokraft/html-element
 */

use \Motokraft\HtmlElement\HtmlElement;

/**
 *
 * Implements the API for adding after the html element
 *
 */

trait AfterTrait
{
    /**
     * Array of values after html element
     *
     * @var array<string|HtmlElement>
     */
	private array $after = [];

    /**
     * Adds a string value after an html element
     *
     * @param string $value string value
     * @param bool $escape Removes extra garbage from a string
     *
     * @return HtmlElement Returns the current class instance
     */
	function after(string $result, bool $escape = true) : HtmlElement
	{
        if($escape)
        {
            $result = $this->escape($result);
        }

        array_push($this->after, $result);
        return $this;
	}

    /**
     * Creates a new instance of the HtmlElement class and adds it before the html element
     *
     * @param HtmlElement $element An instance of the class to be added after the html element
     *
     * @return HtmlElement Returns the passed instance of the HtmlElement class
     */
    function afterHtml(HtmlElement $element) : HtmlElement
	{
        $element->setLevel($this->level);
        $element->setParent($this);

        array_push($this->after, $element);
        return $element;
	}

    /**
     * Creates a new instance of the HtmlElement class and adds it after the html element
     *
     * @param string $type Contains the element's html tag
     * @param array $attrs Contains an array of attributes
     *
     * @return HtmlElement Returns the created instance of the HtmlElement class
     */
    function afterCreateHtml(string $type, array $attrs = [])
	{
        $result = new HtmlElement($type, $attrs);
        return $this->afterHtml($result);
	}
}