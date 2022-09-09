<?php namespace Motokraft\HtmlElement\Iterator\Filter;

/**
 * @copyright   2022 motokraft. MIT License
 * @link https://github.com/motokraft/html-element
 */

use \Motokraft\HtmlElement\HtmlElement;

class NameIterator extends FilterIterator
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

        if(!$current->hasAttribute('name'))
        {
            return false;
        }

        $name = $current->getAttribute('name');
        $value = (string) $this->getValue();

        return ($name->getValue() === $value);
    }
}