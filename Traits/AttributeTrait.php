<?php namespace Motokraft\HtmlElement\Traits;

/**
 * @copyright   2022 motokraft. MIT License
 * @link https://github.com/motokraft/html-element
 */

use \Motokraft\HtmlElement\HtmlHelper;
use \Motokraft\HtmlElement\Attributes\BaseAttribute;
use \Motokraft\HtmlElement\Exception\AttributeClassNotFound;
use \Motokraft\HtmlElement\Exception\AttributeExtends;

/**
 *
 * Implements an API interface for working with attributes
 *
 */

trait AttributeTrait
{
    /**
     * Contains an array of attributes
     *
     * @var array<string, Attributes\BaseAttribute>
     */
    private array $attrs = [];

    /**
     * Adds attributes in an array
     *
     * @param array<name, value> $attrs Array of attributes
     *
     * @return void
     */
    function loadAttributes(array $attrs) : void
    {
        foreach($attrs as $name => $value)
        {
            if(strtolower($name) === 'class')
            {
                $this->addClass($value);
            }
            else if(strtolower($name) === 'before')
            {
                $this->before($value);
            }
            else if(strtolower($name) === 'html')
            {
                $this->html($value);
            }
            else if(strtolower($name) === 'after')
            {
                $this->after($value);
            }
            else if(strtolower($name) === 'id')
            {
                $this->setId($value);
            }
            else if(strtolower($name) === 'level')
            {
                $this->setLevel((string) $value);
            }
            else
            {
                $this->addAttribute($name, $value);
            }
        }
    }

    /**
     * Adds one attribute
     *
     * @param string $name Attribute name
     * @param mixed $value Attribute value
     *
     * @return BaseAttribute Single attribute class
     */
    function addAttribute(string $name, $value = null) : BaseAttribute
    {
        if(!$class = HtmlHelper::getAttribute($name))
        {
            $class = HtmlHelper::getAttribute('_default');
        }

        if(!class_exists($class))
        {
            throw new AttributeClassNotFound($class);
        }

        $result = new $class($name, $value);

        if(!$result instanceof BaseAttribute)
        {
            throw new AttributeExtends($result);
        }

        $this->attrs[$name] = $result;
        return $result;
    }

    /**
     * Returns an attribute class by name
     *
     * @param string $name Attribute name
     *
     * @return BaseAttribute Single attribute class
     * @return bool false Attribute not found
     */
    function getAttribute(string $name) : bool|BaseAttribute
    {
        if(!$this->hasAttribute($name))
        {
            return false;
        }

        return $this->attrs[$name];
    }

    /**
     * Removes an attribute class by name
     *
     * @param string $name Attribute name
     *
     * @return bool true Attribute removed successfully
     * @return bool false Attribute not found
     */
    function removeAttribute(string $name) : bool
    {
        if(!$this->hasAttribute($name))
        {
            return false;
        }

        unset($this->attrs[$name]);
        return true;
    }

    /**
     * Checks for the existence of an attribute by name
     *
     * @param string $name Attribute name
     *
     * @return bool true Attribute exists
     * @return bool false Attribute not found
     */
    function hasAttribute(string $name) : bool
    {
        return isset($this->attrs[$name]);
    }

    /**
     * Returns an array of attributes
     *
     * @return array Array of attributes
     */
    function getAttributes() : array
    {
        return $this->attrs;
    }

    /**
     * Adds one data attribute
     *
     * @param string $name Attribute name
     * @param mixed $value Attribute value
     *
     * @return BaseAttribute Single attribute class
     */
    function addAttrData(string $name, $value = null) : BaseAttribute
    {
        return $this->addAttribute('data-' . $name, $value);
    }

    /**
     * Returns the attribute's data class by name
     *
     * @param string $name Attribute name
     *
     * @return BaseAttribute Single attribute class
     * @return bool false Attribute not found
     */
    function getAttrData(string $name, $value = null) : bool|BaseAttribute
    {
        return $this->getAttribute('data-' . $name, $value);
    }

    /**
     * Removes the attribute's data class by name
     *
     * @param string $name Attribute name
     *
     * @return bool true Attribute removed successfully
     * @return bool false Attribute not found
     */
    function removeAttrData(string $name) : bool
    {
        return $this->removeAttribute('data-' . $name);
    }

    /**
     * Checks for the presence of a data attribute by name
     *
     * @param string $name Attribute name
     *
     * @return bool true Attribute exists
     * @return bool false Attribute not found
     */
    function hasAttrData(string $name) : bool
    {
        return $this->hasAttribute('data-' . $name);
    }

    /**
     * Returns an array of data attributes
     *
     * @return array Array of data attributes
     */
    function getAttrsData() : array
    {
        $filter_attr = function (BaseAttribute $attr)
        {
            $name = (string) $attr->getName();
            return preg_match('/data-(.*)/m', $name);
        };

        return array_filter($this->attrs, $filter_attr);
    }

    /**
     * Adds one aria attribute
     *
     * @param string $name Attribute name
     * @param mixed $value Attribute value
     *
     * @return BaseAttribute Single attribute class
     */
    function addAttrAria(string $name, $value = null) : BaseAttribute
    {
        return $this->addAttribute('aria-' . $name, $value);
    }

    /**
     * Returns the attribute's aria class by name
     *
     * @param string $name Attribute name
     *
     * @return BaseAttribute Single attribute class
     * @return bool false Attribute not found
     */
    function getAttrAria(string $name, $value = null) : bool|BaseAttribute
    {
        return $this->getAttribute('aria-' . $name, $value);
    }

    /**
     * Removes the attribute's aria class by name
     *
     * @param string $name Attribute name
     *
     * @return bool true Attribute removed successfully
     * @return bool false Attribute not found
     */
    function removeAttrAria(string $name) : bool
    {
        return $this->removeAttribute('aria-' . $name);
    }

    /**
     * Checks for the presence of a aria attribute by name
     *
     * @param string $name Attribute name
     *
     * @return bool true Attribute exists
     * @return bool false Attribute not found
     */
    function hasAttrAria(string $name) : bool
    {
        return $this->hasAttribute('aria-' . $name);
    }

    /**
     * Returns an array of aria attributes
     *
     * @return array Array of aria attributes
     */
    function getAttrsAria() : array
    {
        $filter_attr = function (BaseAttribute $attr)
        {
            $name = (string) $attr->getName();
            return preg_match('/aria-(.*)/m', $name);
        };

        return array_filter($this->attrs, $filter_attr);
    }
}