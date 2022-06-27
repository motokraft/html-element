<?php namespace Motokraft\HtmlElement\Iterator\Filter;

/**
 * @copyright   2022 motokraft. MIT License
 * @link https://github.com/motokraft/html-element
 */

use \Motokraft\HtmlElement\HtmlElement;

abstract class FilterIterator extends \RecursiveFilterIterator
{
    private $value;

    function __construct(\RecursiveIterator $iterator, string $value)
    {
        parent::__construct($iterator);
        $this->value = $value;
    }

    function getArray() : array
    {
        $result = [];

        foreach($this as $item)
        {
            array_push($result, $item);
        }

        return $result;
    }

    protected function getValue() : null|string
    {
        return $this->value;
    }
}