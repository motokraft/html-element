<?php namespace Motokraft\HtmlElement\Traits;

/**
 * @copyright   2022 motokraft. MIT License
 * @link https://github.com/motokraft/html-element
 */

use \Motokraft\HtmlElement\HtmlHelper;
use \Motokraft\Object\Collection;
use \Motokraft\HtmlElement\Attributes\AbstractAttribute;
use \Motokraft\HtmlElement\Attributes\AttributeInterface;
use \Motokraft\HtmlElement\Exception\Attribute\AttributeClassNotFound;
use \Motokraft\HtmlElement\Exception\Attribute\AttributeImplement;
use \Motokraft\HtmlElement\Exception\Attribute\AttributeExtends;

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
     * @var array<string, Attributes\AttributeInterface>
     */
    private Collection $attrs;

    /**
     * Adds attributes in an array
     *
     * @param array<name, value> $attrs Array of attributes
     *
     * @return void
     */
    function loadAttributes(Collection|array $attrs) : void
    {
        if(!$attrs instanceof Collection)
        {
            $attrs = new Collection($attrs);
        }

        $map = function (mixed $value, string $name)
        {
            switch(strtolower($name))
            {
                case 'class':
                    $this->addClass($value);
                break;
                case 'before':
                    $this->before($value);
                break;
                case 'html':
                    $this->html($value);
                break;
                case 'after':
                    $this->after($value);
                break;
                case 'id':
                    $this->setId($value);
                break;
                case 'level':
                    $this->setLevel($value);
                break;
                default:
                    $this->addAttribute($name, $value);
                break;
            }
        };

        $attrs->each($map);
    }

    /**
     * Adds one attribute
     *
     * @param string $name Attribute name
     * @param mixed $value Attribute value
     *
     * @return AttributeInterface Single attribute class
     */
    function addAttribute(string $name, mixed $value = null) : AttributeInterface
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

        if(!$result instanceof AttributeInterface)
        {
            throw new AttributeImplement($result);
        }

        if(!$result instanceof AbstractAttribute)
        {
            throw new AttributeExtends($result);
        }

        $this->attrs->set($name, $result);
        return $result;
    }

    /**
     * Returns an attribute class by name
     *
     * @param string $name Attribute name
     *
     * @return AttributeInterface Single attribute class
     * @return bool false Attribute not found
     */
    function getAttribute(string $name) : bool|AttributeInterface
    {
        return $this->attrs->get($name, false);
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
        return $this->attrs->remove($name);
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
        return $this->attrs->hasKey($name);
    }

    /**
     * Returns an array of attributes
     *
     * @return Collection of attributes
     */
    function getAttributes() : Collection
    {
        return $this->attrs;
    }

    /**
     * Adds one data attribute
     *
     * @param string $name Attribute name
     * @param mixed $value Attribute value
     *
     * @return AttributeInterface Single attribute class
     */
    function addAttrData(string $name, mixed $value = null) : AttributeInterface
    {
        return $this->addAttribute('data-' . $name, $value);
    }

    /**
     * Returns the attribute's data class by name
     *
     * @param string $name Attribute name
     *
     * @return AttributeInterface Single attribute class
     * @return bool false Attribute not found
     */
    function getAttrData(string $name, mixed $value = null) : bool|AttributeInterface
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
     * @return Collection of attributes
     */
    function getAttrsData() : Collection
    {
        $filter = function (AbstractAttribute $attr)
        {
            $name = (string) $attr->getName();
            return preg_match('/data-(.*)/m', $name);
        };

        return $this->attrs->filter($filter);
    }

    /**
     * Adds one aria attribute
     *
     * @param string $name Attribute name
     * @param mixed $value Attribute value
     *
     * @return AttributeInterface Single attribute class
     */
    function addAttrAria(string $name, $value = null) : AttributeInterface
    {
        return $this->addAttribute('aria-' . $name, $value);
    }

    /**
     * Returns the attribute's aria class by name
     *
     * @param string $name Attribute name
     *
     * @return AttributeInterface Single attribute class
     * @return bool false Attribute not found
     */
    function getAttrAria(string $name, $value = null) : bool|AttributeInterface
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
     * @return Collection of attributes
     */
    function getAttrsAria() : Collection
    {
        $filter = function (AbstractAttribute $attr)
        {
            $name = (string) $attr->getName();
            return preg_match('/aria-(.*)/m', $name);
        };

        return $this->attrs->filter($filter);
    }
}