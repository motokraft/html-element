<?php namespace Motokraft\HtmlElement\Iterator\Filter;

/**
 * @copyright   2022 motokraft. MIT License
 * @link https://github.com/motokraft/html-element
 */

use \Motokraft\HtmlElement\HtmlElement;

class TagNameIterator extends FilterIterator
{
    function accept() : bool
    {
        $current = parent::current();

        if(!$current instanceof HtmlElement)
        {
            return false;
        }

        $value = (string) $this->getValue();
        return $current->hasType($value);
    }
}