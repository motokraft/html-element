<?php namespace Motokraft\HtmlElement\Event;

/**
 * @copyright   2022 motokraft. MIT License
 * @link https://github.com/motokraft/html-element
 */

use \Motokraft\HtmlElement\HtmlElement;
use \Motokraft\Object\BaseObject;

abstract class BaseEvent implements EventInterface
{
    private $options;

    function __construct()
    {
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
}