<?php namespace Motokraft\HtmlElement\Iterator;

/**
 * @copyright   2022 motokraft. MIT License
 * @link https://github.com/motokraft/html-element
 */

use \Motokraft\HtmlElement\HtmlElement;

class HtmlParentIterator extends \RecursiveIteratorIterator implements \RecursiveIterator
{
    function __construct(HtmlElement $element)
    {
        $iterator = new \RecursiveArrayIterator(
            [$element->getParent()]
        );

        parent::__construct($iterator, 1);
    }

    function callHasChildren() : bool
    {
        $element = parent::current();

        if(!$element instanceof HtmlElement)
        {
            return false;
        }

        $parent = $element->getParent();
        return ($parent instanceof HtmlElement);
    }

    function callGetChildren() : bool|\RecursiveArrayIterator
    {
        $element = parent::current();

        if(!$element instanceof HtmlElement)
        {
            return false;
        }

        $parent = $element->getParent();
        return new \RecursiveArrayIterator([$parent]);
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