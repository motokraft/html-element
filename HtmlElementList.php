<?php namespace Motokraft\HtmlElement;

/**
 * @copyright   2022 motokraft. MIT License
 * @link https://github.com/motokraft/html-element
 */

use \Motokraft\HtmlElement\HtmlElement;

class HtmlElementList extends \ArrayIterator
{
    function addClass(string $value)
    {
        $filter_item = function ($item)
        {
            return ($item instanceof HtmlElement);
        };

        $items = $this->filter($filter_item);

        $map_item = function ($item) use (&$value)
        {
            $item->addClass($value);
            return $item;
        };

        return $items->map($map_item);
    }

    function addAttribute(string $name, $value)
    {
        $filter_item = function ($item)
        {
            return ($item instanceof HtmlElement);
        };

        $items = $this->filter($filter_item);

        $map_item = function ($item) use (&$name, &$value)
        {
            $item->addAttribute($name, $value);
            return $item;
        };

        return $items->map($map_item);
    }

    function filter(callable $func)
    {
        $result = new static;

        foreach($this as $item)
        {
            if(!$func($item))
            {
                continue;
            }

            $result->append($item);
        }

        return $result;
    }

    function map(callable $func)
    {
        $result = new static;

        foreach($this as $item)
        {
            $result->append($func($item));
        }

        return $result;
    }
}