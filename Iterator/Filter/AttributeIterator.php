<?php namespace Motokraft\HtmlElement\Iterator\Filter;

/**
 * @copyright   2022 motokraft. MIT License
 * @link https://github.com/motokraft/html-element
 */

use \Motokraft\HtmlElement\HtmlElement;

class AttributeIterator extends FilterIterator
{
    function accept() : bool
    {
        if(!$current = parent::current())
        {
            return false;
        }

        if(!$current instanceof HtmlElement)
        {
            return false;
        }

        $value = (string) $this->getValue();
        return $current->hasAttribute($value);
    }
}