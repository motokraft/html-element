<?php namespace Motokraft\HtmlElement\Traits;

/**
 * @copyright   2022 motokraft. MIT License
 * @link https://github.com/motokraft/html-element
 */

use \Motokraft\HtmlElement\Attributes\BaseAttribute;
use \Motokraft\HtmlElement\HtmlHelper;

trait AttributeTrait
{
    function loadAttributes(array $attrs)
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

    function addAttribute(string $name, $value = null) : BaseAttribute
    {
        if(!$class = HtmlHelper::getAttribute($name))
        {
            $class = BaseAttribute::class;
        }

        $result = new $class($name, $value);

        if(!$result instanceof BaseAttribute)
        {
            throw new \Exception('The attribute class must be inherited from the base class ' . BaseAttribute::class);
        }

        $this->attrs[$name] = $result;
        return $result;
    }

    function getAttribute(string $name)
    {
        if(!$this->hasAttribute($name))
        {
            return false;
        }

        return $this->attrs[$name];
    }

    function removeAttribute(string $name) : bool
    {
        if(!$this->hasAttribute($name))
        {
            return false;
        }

        unset($this->attrs[$name]);
        return true;
    }

    function hasAttribute(string $name) : bool
    {
        return isset($this->attrs[$name]);
    }

    function getAttributes() : array
    {
        return $this->attrs;
    }

    function addAttrData(string $name, $value = null) : BaseAttribute
    {
        return $this->addAttribute('data-' . $name, $value);
    }

    function getAttrData(string $name, $value = null)
    {
        return $this->getAttribute('data-' . $name, $value);
    }

    function removeAttrData(string $name) : bool
    {
        return $this->removeAttribute('data-' . $name);
    }

    function hasAttrData(string $name) : bool
    {
        return $this->hasAttribute('data-' . $name);
    }

    function getAttrsData() : array
    {
        $filter_attr = function (BaseAttribute $attr)
        {
            $name = (string) $attr->getName();
            return preg_match('/data-(.*)/m', $name);
        };

        return array_filter($this->attrs, $filter_attr);
    }

    function addAttrAria(string $name, $value = null) : BaseAttribute
    {
        return $this->addAttribute('aria-' . $name, $value);
    }

    function getAttrAria(string $name, $value = null)
    {
        return $this->getAttribute('aria-' . $name, $value);
    }

    function removeAttrAria(string $name) : bool
    {
        return $this->removeAttribute('aria-' . $name);
    }

    function hasAttrAria(string $name) : bool
    {
        return $this->hasAttribute('aria-' . $name);
    }

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