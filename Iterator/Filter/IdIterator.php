<?php namespace Motokraft\HtmlElement\Iterator\Filter;

/**
 * @copyright   2022 motokraft. MIT License
 * @link https://github.com/motokraft/html-element
 */

use \Motokraft\HtmlElement\HtmlElement;

class IdIterator extends FilterIterator
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

        if(!$current->hasAttribute('id'))
        {
            return false;
        }

        $id = $current->getAttribute('id');
        $value = (string) $this->getValue();

        return ($id->getValue() === $value);
    }
}