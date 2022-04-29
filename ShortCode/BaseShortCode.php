<?php namespace Motokraft\HtmlElement\ShortCode;

/**
 * @copyright   2022 motokraft. MIT License
 * @link https://github.com/motokraft/html-element
 */

use \Motokraft\HtmlElement\HtmlElement;
use \Motokraft\Object\BaseObject;

class BaseShortCode extends HtmlElement implements ShortCodeInterface
{
    private $options;

    function __construct(string $type,
        array $attrs = [], array $options = [])
    {
        parent::__construct($type, $attrs);
        $this->options = new BaseObject;

        if(!empty($options))
        {
            $this->loadOptions($options);
        }
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
}