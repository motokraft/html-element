<?php namespace Motokraft\HtmlElement\Iterator\Filter;

/**
 * @copyright   2022 motokraft. MIT License
 * @link https://github.com/motokraft/html-element
 */

class NameIterator extends AttrIterator
{
    private $name;

    function __construct(\RecursiveIterator $iterator, string $name)
    {
        parent::__construct($iterator, 'name');
        $this->name = $name;
    }

    function accept()
    {
        if(!parent::accept())
        {
            return false;
        }

        $current = parent::current();

        $name = $current->getAttribute('name');
        return ($name->getValue() === $this->name);
    }
}