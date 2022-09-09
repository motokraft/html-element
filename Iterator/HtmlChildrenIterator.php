<?php namespace Motokraft\HtmlElement\Iterator;

/**
 * @copyright   2022 motokraft. MIT License
 * @link https://github.com/motokraft/html-element
 */

use \Motokraft\HtmlElement\HtmlElement;

class HtmlChildrenIterator extends \RecursiveIteratorIterator implements \RecursiveIterator
{
    function __construct(HtmlElement $element)
    {
        $items = $element->getChildrens();

        $filter_item = function ($item)
        {
            return ($item instanceof HtmlElement);
        };

        $items = array_filter($items, $filter_item);
        $iterator = new \RecursiveArrayIterator($items);

        parent::__construct($iterator, 1);
    }

    function callGetChildren() : bool|\RecursiveArrayIterator
    {
        $element = parent::current();

        if(!$element instanceof HtmlElement)
        {
            return false;
        }

        $items = (array) $element->getChildrens();
        return new \RecursiveArrayIterator($items);
    }

    function callHasChildren() : bool
    {
        $element = parent::current();

        if(!$element instanceof HtmlElement)
        {
            return false;
        }

        $items = $element->getChildrens();
        return (count($items) > 0);
    }

    function hasChildren() : bool
    {
        return $this->callHasChildren();
    }

    function getChildren() : bool|\RecursiveArrayIterator
    {
        return $this->callGetChildren();
    }
}