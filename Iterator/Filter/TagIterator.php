<?php namespace Motokraft\HtmlElement\Iterator\Filter;

/**
 * @copyright   2022 motokraft. MIT License
 * @link https://github.com/motokraft/html-element
 */

use \Motokraft\HtmlElement\HtmlElement;

class TagIterator extends \RecursiveFilterIterator
{
    private $tag;

    function __construct(\RecursiveIterator $iterator, string $tag)
    {
        parent::__construct($iterator);
        $this->tag = $tag;
    }

    function accept()
    {
        $current = parent::current();

        if(!$current instanceof HtmlElement)
        {
            return false;
        }

        return $current->hasType($this->tag);
    }
}