<?php namespace Motokraft\HtmlElement\Event;

/**
 * @copyright   2022 motokraft. MIT License
 * @link https://github.com/motokraft/html-element
 */

use \Motokraft\HtmlElement\HtmlElement;
use \Motokraft\Object\BaseObject;

class ObjectEvent implements EventInterface
{
    private $name;
    private $element;
    private $method = 'run';
    private $before_method;
    private $after_method = 'Event';
    private $options;

    function __construct(string $name, HtmlElement $element)
    {
        $this->name = $name;
        $this->element = $element;

        $this->options = new BaseObject;
    }

    function loadOptions(array $options) : static
    {
        $this->options->loadArray($options);
        return $this;
    }

    function setOption(string $name, $value) : static
    {
        $this->options->set($name, $value);
        return $this;
    }

    function getOption(string $name, $default = null)
    {
        return $this->options->get($name, $default);
    }

    function removeOption(string $name) : bool
    {
        return $this->options->remove($name);
    }

    function hasOption(string $name) : bool
    {
        return $this->options->has($name);
    }

    function setMethod(string $method) : static
    {
        $this->method = $method;
        return $this;
    }

    function setBeforeMethod(string $before) : static
    {
        $this->before_method = $before;
        return $this;
    }

    function setAfterMethod(string $after) : static
    {
        $this->after_method = $after;
        return $this;
    }

    function getName() : null|string
    {
        return $this->name;
    }

    function getElement() : HtmlElement
    {
        return $this->element;
    }

    function getMethod() : null|string
    {
        return $this->method;
    }

    function getBeforeMethod() : null|string
    {
        return $this->before_method;
    }

    function getAfterMethod() : null|string
    {
        return $this->after_method;
    }

    function getMethodName() : null|string
    {
        $result = $this->getMethod();

        if($before = $this->getBeforeMethod())
        {
            $result = $before . $result;
        }

        if($after = $this->getAfterMethod())
        {
            $result .= ucfirst($after);
        }

        return $result;
    }
}