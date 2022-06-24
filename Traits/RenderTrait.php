<?php namespace Motokraft\HtmlElement\Traits;

/**
 * @copyright   2022 motokraft. MIT License
 * @link https://github.com/motokraft/html-element
 */

trait RenderTrait
{
    protected static $render = [
        'meta' => '<{type}{attrs}>',
        'title' => '<{type}>{body}</{type}>',
        'link' => '<{type}{attrs}>',
        'input' => '<{type}{attrs}>',
        'hr' => '<{type}{attrs}>',
        'img' => '<{type}{attrs}>',
        'shortcode' => '<{type}{attrs} />',
        '_default' => '<{type}{attrs}>{body}</{type}>'
    ];

    static function addRenders(array $items)
    {
        foreach($items as $type => $tmpl)
        {
            self::addRender($type, $tmpl);
        }
    }

    static function addRender(string $name, $value)
    {
        static::$render[$name] = $value;
    }

    static function getRender(string $name, $default = null)
    {
        if(!static::hasRender($name))
        {
            return $default;
        }

        return static::$render[$name];
    }

    static function removeRender(string $name)
    {
        if(!static::hasRender($name))
        {
            return false;
        }

        unset(static::$render[$name]);
        return true;
    }

    static function hasRender(string $name)
    {
        return isset(static::$render[$name]);
    }
}