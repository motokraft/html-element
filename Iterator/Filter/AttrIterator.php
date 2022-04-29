<?php namespace Motokraft\HtmlElement\Iterator\Filter;

/**
 * @copyright   2022 motokraft. MIT License
 * @link https://github.com/motokraft/html-element
 */

use \Motokraft\HtmlElement\HtmlElement;

class AttrIterator extends \RecursiveFilterIterator
{
    private $attr;

    function __construct(\RecursiveIterator $iterator, string $attr)
    {
        parent::__construct($iterator);
        $this->attr = $attr;
    }

    function accept()
    {
        $current = parent::current();

        if(!$current instanceof HtmlElement)
        {
            return false;
        }

        return $current->hasAttribute($this->attr);
    }
}