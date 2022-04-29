<?php namespace Motokraft\HtmlElement\Traits;

/**
 * @copyright   2022 motokraft. MIT License
 * @link https://github.com/motokraft/html-element
 */

use \Motokraft\HtmlElement\Styles\BaseStyle;
use \Motokraft\HtmlElement\Iterator\ItemsIterator;
use \Motokraft\HtmlElement\HtmlHelper;

trait StyleTrait
{
    function addStyle(string $name) : BaseStyle
    {
        if(!$class = HtmlHelper::getStyle($name))
        {
            $class = BaseStyle::class;
        }

        $class = new \ReflectionClass($class);

        $args = array_slice(func_get_args(), 1);
        $style = $class->newInstanceArgs($args);

        $style->setName($name);

        $this->styles[$name] = $style;
        return $style;
    }

    function getStyle(string $name) : bool|BaseStyle
    {
        if(!$this->hasStyle($name))
        {
            return false;
        }

        return $this->styles[$name];
    }

    function removeStyle(string $name) : bool
    {
        if(!$this->hasStyle($name))
        {
            return false;
        }

        unset($this->styles[$name]);
        return true;
    }

    function hasStyle(string $name) : bool
    {
        return isset($this->styles[$name]);
    }

    function getStyles() : ItemsIterator
    {
        return $this->styles;
    }
}