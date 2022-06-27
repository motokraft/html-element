<?php namespace Motokraft\HtmlElement\Traits;

/**
 * @copyright   2022 motokraft. MIT License
 * @link https://github.com/motokraft/html-element
 */

use \Motokraft\HtmlElement\Iterator\HtmlChildrenIterator;
use \Motokraft\HtmlElement\Iterator\HtmlParentIterator;
use \Motokraft\HtmlElement\Iterator\Filter\IdIterator;
use \Motokraft\HtmlElement\Iterator\Filter\ClassIterator;
use \Motokraft\HtmlElement\Iterator\Filter\NameIterator;
use \Motokraft\HtmlElement\Iterator\Filter\TagNameIterator;
use \Motokraft\HtmlElement\Iterator\Filter\AttributeIterator;
use \Motokraft\HtmlElement\HtmlElementList;

trait SelectorTrait
{
    function getFirstElement() : bool|static
    {
        if(!$parent = $this->getParent())
        {
            return false;
        }

        if(!$items = $parent->getChildrens())
        {
            return false;
        }

        return reset($items);
    }

    function getPrevElement() : bool|static
    {
        if(!$parent = $this->getParent())
        {
            return false;
        }

        if(!$items = $parent->getChildrens())
        {
            return false;
        }

        foreach($items as $key => $item)
        {
            if($item !== $this)
            {
                continue;
            }

            if(isset($items[($key - 1)]))
            {
                return $items[($key - 1)];
            }
        }

        return false;
    }

    function getNextElement() : bool|static
    {
        if(!$parent = $this->getParent())
        {
            return false;
        }

        if(!$items = $parent->getChildrens())
        {
            return false;
        }

        foreach($items as $key => $item)
        {
            if($item !== $this)
            {
                continue;
            }

            if(isset($items[($key + 1)]))
            {
                return $items[($key + 1)];
            }
        }

        return false;
    }

    function getLastElement() : bool|static
    {
        if(!$parent = $this->getParent())
        {
            return false;
        }

        if(!$items = $parent->getChildrens())
        {
            return false;
        }

        return end($items);
    }

    function getElementById(string $id) : bool|static
    {
        $iterator = new HtmlChildrenIterator($this);
        return $this->_getById($iterator, $id);
    }

    function getElementByName(string $name) : bool|static
    {
        $iterator = new HtmlChildrenIterator($this);
        return $this->_getByName($iterator, $name);
    }

    function getElementByClassName(string $class) : HtmlElementList
    {
        $iterator = new HtmlChildrenIterator($this);
        return $this->_getByClassName($iterator, $class);
    }

    function getElementByTagName(string $tag) : HtmlElementList
    {
        $iterator = new HtmlChildrenIterator($this);
        return $this->_getByTagName($iterator, $tag);
    }

    function getElementByAttr(string $attr) : HtmlElementList
    {
        $iterator = new HtmlChildrenIterator($this);
        return $this->_getByAttribute($iterator, $attr);
    }

    function getClosestById(string $id) : bool|static
    {
        $iterator = new HtmlParentIterator($this);
        return $this->_getById($iterator, $id);
    }

    function getClosestByName(string $name) : bool|static
    {
        $iterator = new HtmlParentIterator($this);
        return $this->_getByName($iterator, $name);
    }

    function getClosestByClassName(string $class) : HtmlElementList
    {
        $iterator = new HtmlParentIterator($this);
        return $this->_getByClassName($iterator, $class);
    }

    function getClosestByTagName(string $tag) : HtmlElementList
    {
        $iterator = new HtmlParentIterator($this);
        return $this->_getByTagName($iterator, $tag);
    }

    function getClosestByAttr(string $attr) : HtmlElementList
    {
        $iterator = new HtmlParentIterator($this);
        return $this->_getByAttribute($iterator, $attr);
    }

    private function _getById(\RecursiveIterator $iterator, string $id) : bool|static
    {
        $result = new IdIterator($iterator, $id);
        $result->rewind();

        if(!$result = $result->current())
        {
            return false;
        }

        return $result;
    }

    private function _getByName(\RecursiveIterator $iterator, string $name) : bool|static
    {
        $result = new NameIterator($iterator, $name);
        $result->rewind();

        if(!$result = $result->current())
        {
            return false;
        }

        return $result;
    }

    private function _getByClassName(\RecursiveIterator $iterator, string $class) : HtmlElementList
    {
        $items = new ClassIterator($iterator, $class);
        return new HtmlElementList($items);
    }

    private function _getByTagName(\RecursiveIterator $iterator, string $tag) : HtmlElementList
    {
        $items = new TagNameIterator($iterator, $tag);
        return new HtmlElementList($items);
    }

    private function _getByAttribute(\RecursiveIterator $iterator, string $attr) : HtmlElementList
    {
        $items = new AttributeIterator($iterator, $attr);
        return new HtmlElementList($items);
    }
}