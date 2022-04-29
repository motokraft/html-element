<?php namespace Motokraft\HtmlElement\Iterator;

/**
 * @copyright   2022 motokraft. MIT License
 * @link https://github.com/motokraft/html-element
 */

use \Motokraft\HtmlElement\HtmlElement;

class HtmlElementIterator extends \RecursiveIteratorIterator implements \RecursiveIterator
{
    function __construct(HtmlElement $element)
    {
        $items = $element->getChildrens();

        $iterator = new \RecursiveArrayIterator($items);
        parent::__construct($iterator, 1);
    }

    function callGetChildren()
    {
        $element = parent::current();

        if(!$element instanceof HtmlElement)
        {
            return false;
        }

        $items = (array) $element->getChildrens();
        return new \RecursiveArrayIterator($items);
    }

    function callHasChildren()
    {
        $element = parent::current();

        if(!$element instanceof HtmlElement)
        {
            return false;
        }

        $items = $element->getChildrens();
        return (count($items) > 0);
    }

    function hasChildren()
    {
        return $this->callHasChildren();
    }

    function getChildren()
    {
        return $this->callGetChildren();
    }
}