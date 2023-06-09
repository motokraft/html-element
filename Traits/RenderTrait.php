<?php namespace Motokraft\HtmlElement\Traits;

/**
 * @copyright   2022 motokraft. MIT License
 * @link https://github.com/motokraft/html-element
 */

/**
 *
 * Implements an API interface for string output
 *
 */

trait RenderTrait
{
    /**
     * Array of output templates for standard HTML elements
     *
     */
    protected static $render = [
        'meta' => '<{type}{attrs}>',
        'base' => '<{type}{attrs}>',
        'title' => '<{type}>{body}</{type}>',
        'link' => '<{type}{attrs}>',
        'input' => '<{type}{attrs}>',
        'hr' => '<{type}{attrs}>',
        'img' => '<{type}{attrs}>',
        'embed' => '<{type}{attrs}>',
        'br' => '<{type}{attrs}>',
        'shortcode' => '<{type}{attrs} />',
        '_default' => '<{type}{attrs}>{body}</{type}>'
    ];

    /**
     * Adds an array of html element output templates
     *
     * @param array<name, template> $items Array of output templates
     *
     * @return void
     */
    static function addRenders(array $items) : void
    {
        foreach($items as $type => $tmpl)
        {
            self::addRender($type, $tmpl);
        }
    }

    /**
     * Adds an html element output template
     *
     * @param string $name HTML element tag name
     * @param string $value HTML element output template
     *
     * @return void
     */
    static function addRender(string $name, string $value) : void
    {
        static::$render[$name] = $value;
    }

    /**
     * Returns the output template of the html element
     *
     * @param string $name HTML element tag name
     *
     * @return string HTML element output template
     * @return bool false Element html tag not found
     */
    static function getRender(string $name) : bool|string
    {
        if(!static::hasRender($name))
        {
            return false;
        }

        return static::$render[$name];
    }

    /**
     * Removes the html element's output template
     *
     * @param string $name HTML element tag name
     *
     * @return bool true Output template deleted successfully
     * @return bool false Output template not found
     */
    static function removeRender(string $name) : bool
    {
        if(!static::hasRender($name))
        {
            return false;
        }

        unset(static::$render[$name]);
        return true;
    }

    /**
     * Checks for the presence of an html element output template
     *
     * @param string $name HTML element tag name
     *
     * @return bool true HTML element output template exists
     * @return bool false HTML element output template not found
     */
    static function hasRender(string $name) : bool
    {
        return isset(static::$render[$name]);
    }
}