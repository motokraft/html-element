<?php namespace Motokraft\HtmlElement\Traits;

/**
 * @copyright   2022 motokraft. MIT License
 * @link https://github.com/motokraft/html-element
 */

use \Motokraft\HtmlElement\Iterator\HtmlElementIterator;
use \Motokraft\HtmlElement\Iterator\Filter\IdIterator;
use \Motokraft\HtmlElement\Iterator\Filter\ClassIterator;
use \Motokraft\HtmlElement\Iterator\Filter\NameIterator;
use \Motokraft\HtmlElement\Iterator\Filter\TagIterator;
use \Motokraft\HtmlElement\HtmlElementList;
use \Motokraft\HtmlElement\HtmlElement;

trait SelectorTrait
{
    function getElementById(string $id)
    {
        $iterator = new HtmlElementIterator($this);
        $elements = new IdIterator($iterator, $id);

        $elements->rewind();
        return $elements->current();
    }

    function getElementByClassName(string $class)
    {
        $iterator = new HtmlElementIterator($this);
        $elements = new ClassIterator($iterator, $class);

        $result = new HtmlElementList;

        foreach($elements as $element)
        {
            $result->append($element);
        }

        return $result;
    }

    function getElementByName(string $name)
    {
        $iterator = new HtmlElementIterator($this);
        $elements = new NameIterator($iterator, $name);

        $result = new HtmlElementList;

        foreach($elements as $element)
        {
            $result->append($element);
        }

        return $result;
    }

    function getElementByTagName(string $tag)
    {
        $iterator = new HtmlElementIterator($this);
        $elements = new TagIterator($iterator, $tag);

        $result = new HtmlElementList;

        foreach($elements as $element)
        {
            $result->append($element);
        }

        return $result;
    }
}