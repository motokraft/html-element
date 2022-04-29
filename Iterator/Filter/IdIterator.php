<?php namespace Motokraft\HtmlElement\Iterator\Filter;

/**
 * @copyright   2022 motokraft. MIT License
 * @link https://github.com/motokraft/html-element
 */

class IdIterator extends AttrIterator
{
    private $id;

    function __construct(\RecursiveIterator $iterator, string $id)
    {
        parent::__construct($iterator, 'id');
        $this->id = $id;
    }

    function accept()
    {
        if(!parent::accept())
        {
            return false;
        }

        $current = parent::current();

        $id = $current->getAttribute('id');
        return ($id->getValue() === $this->id);
    }
}