<?php namespace Motokraft\HtmlElement\Traits;

/**
 * @copyright   2022 motokraft. MIT License
 * @link https://github.com/motokraft/html-element
 */

use \Motokraft\HtmlElement\HtmlElement;
use \Motokraft\HtmlElement\HtmlCollection;
use \Motokraft\HtmlElement\Iterator\HtmlChildrenIterator;
use \Motokraft\HtmlElement\Iterator\HtmlParentIterator;
use \Motokraft\HtmlElement\Iterator\HtmlSiblingIterator;
use \Motokraft\HtmlElement\Iterator\Filter\IdIterator;
use \Motokraft\HtmlElement\Iterator\Filter\ClassIterator;
use \Motokraft\HtmlElement\Iterator\Filter\NameIterator;
use \Motokraft\HtmlElement\Iterator\Filter\TagNameIterator;
use \Motokraft\HtmlElement\Iterator\Filter\AttributeIterator;

/**
 *
 * Implements an API for traversing the DOM tree of html elements
 *
 */

trait SelectorTrait
{
    /**
     * Returns the first child element of the parent class
     *
     * @return HtmlElement HTML element
     * @return bool false The current element has no parent
     * @return bool false Parent element has no children
     */
    function getFirstElement() : bool|HtmlElement
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

    /**
     * Returns the previous element from the current
     *
     * @return HtmlElement HTML element
     * @return bool false The current element has no parent
     * @return bool false Parent element has no children
     */
    function getPrevElement() : bool|HtmlElement
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

    /**
     * Returns the next element from the current
     *
     * @return HtmlElement HTML element
     * @return bool false The current element has no parent
     * @return bool false Parent element has no children
     */
    function getNextElement() : bool|HtmlElement
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

    /**
     * Returns the last child of the parent class
     *
     * @return HtmlElement HTML element
     * @return bool false The current element has no parent
     * @return bool false Parent element has no children
     */
    function getLastElement() : bool|HtmlElement
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

    /**
     * Returns the child html element according to the value of the id attribute
     *
     * @param string $id Id attribute value
     *
     * @return HtmlElement HTML element
     * @return bool false HTML element not found
     */
    function getElementById(string $id) : bool|HtmlElement
    {
        $iterator = new HtmlChildrenIterator($this);
        return $this->_getById($iterator, $id);
    }

    /**
     * Returns the child html element according to the value of the name attribute
     *
     * @param string $id Name attribute value
     *
     * @return HtmlElement HTML element
     * @return bool false HTML element not found
     */
    function getElementByName(string $name) : bool|HtmlElement
    {
        $iterator = new HtmlChildrenIterator($this);
        return $this->_getByName($iterator, $name);
    }

    /**
     * Returns child html elements that have the specified class
     *
     * @param string $class Class attribute value
     *
     * @return HtmlCollection Collection of html elements
     */
    function getElementByClassName(string $class) : HtmlCollection
    {
        $iterator = new HtmlChildrenIterator($this);
        return $this->_getByClassName($iterator, $class);
    }

    /**
     * Returns the child html elements according to the given tag
     *
     * @param string $tag Tag html element
     *
     * @return HtmlCollection Collection of html elements
     */
    function getElementByTagName(string $tag) : HtmlCollection
    {
        $iterator = new HtmlChildrenIterator($this);
        return $this->_getByTagName($iterator, $tag);
    }

    /**
     * Returns the child html elements with the specified attribute name
     *
     * @param string $attr Attribute name html element
     *
     * @return HtmlCollection Collection of html elements
     */
    function getElementByAttr(string $attr) : HtmlCollection
    {
        $iterator = new HtmlChildrenIterator($this);
        return $this->_getByAttribute($iterator, $attr);
    }

    /**
     * Returns the nearest parent html element according to the value of the id attribute
     *
     * @param string $id Id attribute value
     *
     * @return HtmlElement HTML element
     * @return bool false HTML element not found
     */
    function getClosestById(string $id) : bool|HtmlElement
    {
        $iterator = new HtmlParentIterator($this);
        return $this->_getById($iterator, $id);
    }

    /**
     * Returns the parent html element according to the value of the name attribute
     *
     * @param string $id Name attribute value
     *
     * @return HtmlElement HTML element
     * @return bool false HTML element not found
     */
    function getClosestByName(string $name) : bool|HtmlElement
    {
        $iterator = new HtmlParentIterator($this);
        return $this->_getByName($iterator, $name);
    }

    /**
     * Returns parent html elements that have the specified class
     *
     * @param string $class Class attribute value
     *
     * @return HtmlCollection Collection of html elements
     */
    function getClosestByClassName(string $class) : HtmlCollection
    {
        $iterator = new HtmlParentIterator($this);
        return $this->_getByClassName($iterator, $class);
    }

    /**
     * Returns the parent html elements according to the given tag
     *
     * @param string $tag Tag html element
     *
     * @return HtmlCollection Collection of html elements
     */
    function getClosestByTagName(string $tag) : HtmlCollection
    {
        $iterator = new HtmlParentIterator($this);
        return $this->_getByTagName($iterator, $tag);
    }

    /**
     * Returns the parent html elements with the specified attribute name
     *
     * @param string $attr Attribute name html element
     *
     * @return HtmlCollection Collection of html elements
     */
    function getClosestByAttr(string $attr) : HtmlCollection
    {
        $iterator = new HtmlParentIterator($this);
        return $this->_getByAttribute($iterator, $attr);
    }

    private function _getById(\Iterator $iterator, string $id) : bool|HtmlElement
    {
        $result = new IdIterator($iterator, $id);
        $result->rewind();

        if(!$result = $result->current())
        {
            return false;
        }

        return $result;
    }

    private function _getByName(\Iterator $iterator, string $name) : bool|HtmlElement
    {
        $result = new NameIterator($iterator, $name);
        $result->rewind();

        if(!$result = $result->current())
        {
            return false;
        }

        return $result;
    }

    private function _getByClassName(\Iterator $iterator, string $class) : HtmlCollection
    {
        $iterator = new ClassIterator($iterator, $class);
        return new HtmlCollection($iterator->getArray());
    }

    private function _getByTagName(\Iterator $iterator, string $tag) : HtmlCollection
    {
        $iterator = new TagNameIterator($iterator, $tag);
        return new HtmlCollection($iterator->getArray());
    }

    private function _getByAttribute(\Iterator $iterator, string $attr) : HtmlCollection
    {
        $iterator = new AttributeIterator($iterator, $attr);
        return new HtmlCollection($iterator->getArray());
    }
}