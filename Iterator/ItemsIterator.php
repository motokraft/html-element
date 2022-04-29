<?php namespace Motokraft\HtmlElement\Iterator;

/**
 * @copyright   2022 motokraft. MIT License
 * @link https://github.com/motokraft/html-element
 */

class ItemsIterator extends \ArrayIterator
{
    function map(callable $func)
    {
        $result = new \ArrayIterator;

        foreach($this as $key => $item)
        {
            $result[$key] = $func($item, $key);
        }

        return $result;
    }

    function filter(callable $func)
    {
        $result = new ItemsIterator;

        foreach($this as $key => $item)
        {
            if(!$func($item, $key))
            {
                continue;
            }

            $result[$key] = $item;
        }

        return $result;
    }

    function implode(string $separate)
    {
        $result = [];

        foreach($this as $item)
        {
            array_push($result, $item);
        }

        return implode($separate, $result);
    }
}