<?php namespace Motokraft\HtmlElement\Iterator\Filter;

/**
 * @copyright   2022 motokraft. MIT License
 * @link https://github.com/motokraft/html-element
 */

class AttributeIterator extends FilterIterator
{
    function accept() : bool
    {
        if(!$current = parent::current())
        {
            return false;
        }

        $value = (string) $this->getValue();
        return $current->hasAttribute($value);
    }
}