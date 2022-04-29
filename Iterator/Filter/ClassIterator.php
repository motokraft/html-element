<?php namespace Motokraft\HtmlElement\Iterator\Filter;

/**
 * @copyright   2022 motokraft. MIT License
 * @link https://github.com/motokraft/html-element
 */

class ClassIterator extends AttrIterator
{
    private $class;

    function __construct(\RecursiveIterator $iterator, string $class)
    {
        parent::__construct($iterator, 'class');
        $this->class = $class;
    }

    function accept()
    {
        if(!parent::accept())
        {
            return false;
        }

        $current = parent::current();
        return $current->hasClass($this->class);
    }
}