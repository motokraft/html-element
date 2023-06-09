<?php namespace Motokraft\HtmlElement\Traits;

/**
 * @copyright   2022 motokraft. MIT License
 * @link https://github.com/motokraft/html-element
 */

use \Motokraft\HtmlElement\HtmlHelper;
use \Motokraft\HtmlElement\ShortCode\AbstractShortCode;
use \Motokraft\HtmlElement\Exception\ShortCode\ShortCodeClassNotFound;
use \Motokraft\HtmlElement\Exception\ShortCode\ShortCodeNotFound;
use \Motokraft\HtmlElement\Exception\ShortCode\ShortCodeImplement;
use \Motokraft\HtmlElement\Exception\ShortCode\ShortCodeExtends;

/**
 *
 * Implements an API for adding a ShortCode element
 *
 */

trait ShortCodeTrait
{
    /**
     * Adds the AbstractShortCode class before the html element
     *
     * @param AbstractShortCode $element An instance of the class to be added before the html element
     *
     * @return AbstractShortCode Returns the passed instance of the class
     */
    function beforeShortCode(AbstractShortCode $element) : AbstractShortCode
    {
        return $this->beforeHtml($element);
    }

    /**
     * Creates a new instance of the AbstractShortCode class and adds it before the html element
     *
     * @param string $type Contains the element's html tag
     * @param array<string, mixed> $options Array of Custom ShortCode Parameters
     * @param array $attrs Contains an array of attributes
     *
     * @return AbstractShortCode Returns the created instance of the AbstractShortCode class
     */
    function beforeCreateShortCode(string $type,
        array $options = [], array $attrs = []) : AbstractShortCode
    {
        $result = $this->createClassShortCode($type, $options, $attrs);
        return $this->beforeShortCode($result);
    }

    /**
     * Adds the AbstractShortCode class to the beginning of child elements
     *
     * @param AbstractShortCode $element value
     *
     * @return AbstractShortCode Returns the passed instance of the class
     */
    function prependShortCode(AbstractShortCode $element) : AbstractShortCode
    {
        return $this->prependHtml($element);
    }

    /**
     * Creates a new instance of the AbstractShortCode class and adds it to the beginning of child elements
     *
     * @param string $type Contains the element's html tag
     * @param array<string, mixed> $options Array of Custom ShortCode Parameters
     * @param array $attrs Contains an array of attributes
     *
     * @return AbstractShortCode Returns the created instance of the AbstractShortCode class
     */
    function prependCreateShortCode(string $type,
        array $options = [], array $attrs = []) : AbstractShortCode
    {
        $result = $this->createClassShortCode($type, $options, $attrs);
        return $this->prependShortCode($result);
    }

    /**
     * Adds the AbstractShortCode class to the end of child elements
     *
     * @param AbstractShortCode $element value
     *
     * @return AbstractShortCode Returns the passed instance of the class
     */
    function appendShortCode(AbstractShortCode $element) : AbstractShortCode
    {
        return $this->appendHtml($element);
    }

    /**
     * Creates a new instance of the AbstractShortCode class and append it to the end of child elements.
     *
     * @param string $type Contains the element's html tag
     * @param array<string, mixed> $options Array of Custom ShortCode Parameters
     * @param array $attrs Contains an array of attributes
     *
     * @return AbstractShortCode Returns the created instance of the AbstractShortCode class
     */
    function appendCreateShortCode(string $type,
        array $options = [], array $attrs = []) : AbstractShortCode
    {
        $result = $this->createClassShortCode($type, $options, $attrs);
        return $this->appendShortCode($result);
    }

    /**
     * Adds the AbstractShortCode class after the html element
     *
     * @param AbstractShortCode $element value
     *
     * @return AbstractShortCode Returns the passed instance of the class
     */
    function afterShortCode(AbstractShortCode $element) : AbstractShortCode
    {
        return $this->appendHtml($element);
    }

    /**
     * Creates a new instance of the AbstractShortCode class and adds it after the html element
     *
     * @param string $type Contains the element's html tag
     * @param array<string, mixed> $options Array of Custom ShortCode Parameters
     * @param array $attrs Contains an array of attributes
     *
     * @return AbstractShortCode Returns the created instance of the AbstractShortCode class
     */
    function afterCreateShortCode(string $type,
        array $options = [], array $attrs = []) : AbstractShortCode
    {
        $result = $this->createClassShortCode($type, $options, $attrs);
        return $this->afterHtml($result);
    }

    /**
     * Initializing a new AbstractShortCode class
     *
     * @param string $type Contains the element's html tag
     * @param array<string, mixed> $options Array of Custom ShortCode Parameters
     * @param array $attrs Contains an array of attributes
     *
     * @return AbstractShortCode Created an instance of the AbstractShortCode class
     */
    private function createClassShortCode(string $type,
        array $options = [], array $attrs = []) : AbstractShortCode
    {
        if(!HtmlHelper::hasShortCode($type))
        {
            throw new ShortCodeNotFound($type);
        }

        $class = HtmlHelper::getShortCode($type);

        if(!class_exists($class))
        {
            throw new ShortCodeClassNotFound($class);
        }

        $tagname = HtmlHelper::SHORTCODE_DEFAULT_TAGNAME;

        if(!empty($options['tagname']))
        {
            $tagname = $options['tagname'];
        }

        $result = new $class($tagname, $attrs);

        if(!$result instanceof AbstractShortCode)
        {
            throw new ShortCodeImplement($result);
        }

        if(!$result instanceof AbstractShortCode)
        {
            throw new ShortCodeExtends($result);
        }

        if(!empty($options))
        {
            $result->loadArray($options);
        }

        return $result;
    }
}