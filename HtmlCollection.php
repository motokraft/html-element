<?php namespace Motokraft\HtmlElement;

/**
 * @copyright   2022 motokraft. MIT License
 * @link https://github.com/motokraft/html-element
 */

use \Motokraft\HtmlElement\HtmlElement;
use \Motokraft\Object\Collection;

/**
 *
 * Implements the HTML element collections API
 *
 */

class HtmlCollection extends Collection
{   
    /**
     * Adds the specified class to all elements in the collection
     *
     * @param string $value The class value to be added
     *
     * @return void
     */
    function addClass(string $value) : void
    {
        $this->each(
            fn($item) => $item->addClass($value)
        );
    }

    /**
     * Adds an attribute to all elements in the collection
     *
     * @param string $name The name of the added attribute
     * @param string $value The value of the added attribute
     *
     * @return void
     */
    function addAttribute(string $name, $value) : void
    {
        $this->each(
            fn($item) => $item->addAttribute($name, $value)
        );
    }

    /**
     * Returns the first element in the collection
     *
     * @return HtmlElement An instance of the HTML element class
     * @return bool false HTML element collection is empty
     */
    function getFirstElement() : bool|HtmlElement
    {
        if(!$items = $this->getValues())
        {
            return false;
        }

        return reset($items);
    }

    /**
     * Returns the last element of the collection
     *
     * @return HtmlElement An instance of the HTML element class
     * @return bool false HTML element collection is empty
     */
    function getLastElement() : bool|HtmlElement
    {
        if(!$items = $this->getValues())
        {
            return false;
        }

        return end($items);
    }
}