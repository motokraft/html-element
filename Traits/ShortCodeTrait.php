<?php namespace Motokraft\HtmlElement\Traits;

/**
 * @copyright   2022 motokraft. MIT License
 * @link https://github.com/motokraft/html-element
 */

use \Motokraft\HtmlElement\HtmlHelper;
use \Motokraft\HtmlElement\ShortCode\BaseShortCode;
use \Motokraft\HtmlElement\ShortCode\ShortCodeInterface;
use \Motokraft\HtmlElement\Exception\ShortCodeClassNotFound;
use \Motokraft\HtmlElement\Exception\ShortCodeNotFound;
use \Motokraft\HtmlElement\Exception\ShortCodeImplement;
use \Motokraft\HtmlElement\Exception\ShortCodeExtends;

/**
 *
 * Implements an API for adding a ShortCode element
 *
 */

trait ShortCodeTrait
{
    /**
     * Adds the BaseShortCode class before the html element
     *
     * @param ShortCodeInterface $element An instance of the class to be added before the html element
     *
     * @return ShortCodeInterface Returns the passed instance of the class
     */
    function beforeShortCode(ShortCodeInterface $element) : ShortCodeInterface
    {
        return $this->beforeHtml($element);
    }

    /**
     * Creates a new instance of the BaseShortCode class and adds it before the html element
     *
     * @param string $type Contains the element's html tag
     * @param array<string, mixed> $options Array of Custom ShortCode Parameters
     * @param array $attrs Contains an array of attributes
     *
     * @return ShortCodeInterface Returns the created instance of the BaseShortCode class
     */
    function beforeCreateShortCode(string $type,
        array $options = [], array $attrs = []) : ShortCodeInterface
    {
        $result = $this->createClassShortCode($type, $options, $attrs);
        return $this->beforeShortCode($result);
    }

    /**
     * Adds the BaseShortCode class to the beginning of child elements
     *
     * @param ShortCodeInterface $element value
     *
     * @return ShortCodeInterface Returns the passed instance of the class
     */
    function prependShortCode(ShortCodeInterface $element) : ShortCodeInterface
    {
        return $this->prependHtml($element);
    }

    /**
     * Creates a new instance of the BaseShortCode class and adds it to the beginning of child elements
     *
     * @param string $type Contains the element's html tag
     * @param array<string, mixed> $options Array of Custom ShortCode Parameters
     * @param array $attrs Contains an array of attributes
     *
     * @return ShortCodeInterface Returns the created instance of the BaseShortCode class
     */
    function prependCreateShortCode(string $type,
        array $options = [], array $attrs = []) : ShortCodeInterface
    {
        $result = $this->createClassShortCode($type, $options, $attrs);
        return $this->prependShortCode($result);
    }

    /**
     * Adds the BaseShortCode class to the end of child elements
     *
     * @param ShortCodeInterface $element value
     *
     * @return ShortCodeInterface Returns the passed instance of the class
     */
    function appendShortCode(ShortCodeInterface $element) : ShortCodeInterface
    {
        return $this->appendHtml($element);
    }

    /**
     * Creates a new instance of the BaseShortCode class and append it to the end of child elements.
     *
     * @param string $type Contains the element's html tag
     * @param array<string, mixed> $options Array of Custom ShortCode Parameters
     * @param array $attrs Contains an array of attributes
     *
     * @return ShortCodeInterface Returns the created instance of the BaseShortCode class
     */
    function appendCreateShortCode(string $type,
        array $options = [], array $attrs = []) : ShortCodeInterface
    {
        $result = $this->createClassShortCode($type, $options, $attrs);
        return $this->appendShortCode($result);
    }

    /**
     * Adds the BaseShortCode class after the html element
     *
     * @param ShortCodeInterface $element value
     *
     * @return ShortCodeInterface Returns the passed instance of the class
     */
    function afterShortCode(ShortCodeInterface $element) : ShortCodeInterface
    {
        return $this->appendHtml($element);
    }

    /**
     * Creates a new instance of the BaseShortCode class and adds it after the html element
     *
     * @param string $type Contains the element's html tag
     * @param array<string, mixed> $options Array of Custom ShortCode Parameters
     * @param array $attrs Contains an array of attributes
     *
     * @return ShortCodeInterface Returns the created instance of the BaseShortCode class
     */
    function afterCreateShortCode(string $type,
        array $options = [], array $attrs = []) : ShortCodeInterface
    {
        $result = $this->createClassShortCode($type, $options, $attrs);
        return $this->afterHtml($result);
    }

    /**
     * Initializing a new BaseShortCode class
     *
     * @param string $type Contains the element's html tag
     * @param array<string, mixed> $options Array of Custom ShortCode Parameters
     * @param array $attrs Contains an array of attributes
     *
     * @return ShortCodeInterface Created an instance of the BaseShortCode class
     */
    private function createClassShortCode(string $type,
        array $options = [], array $attrs = []) : ShortCodeInterface
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

        if(!$result instanceof ShortCodeInterface)
        {
            throw new ShortCodeImplement($result);
        }

        if(!$result instanceof BaseShortCode)
        {
            throw new ShortCodeExtends($result);
        }

        if(!empty($options))
        {
            $result->loadOptions($options);
        }

        return $result;
    }
}