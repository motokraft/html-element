<?php namespace Motokraft\HtmlElement;

/**
 * @copyright   2022 motokraft. MIT License
 * @link https://github.com/motokraft/html-element
 */

use \Motokraft\HtmlElement\ShortCode\ShortCodeInterface;
use \Motokraft\HtmlElement\Exception\ShortCodeNotFound;
use \Motokraft\HtmlElement\Exception\ShortCodeClassNotFound;
use \Motokraft\HtmlElement\Exception\AttributeTypeNotFound;
use \Motokraft\HtmlElement\Exception\ShortCodeImplement;
use \Motokraft\HtmlElement\Exception\ShortCodeExtends;
use \Motokraft\HtmlElement\Object\Attributes;
use \Motokraft\HtmlElement\Attributes\ClassAttribute;

class HtmlHelper
{
    const REGEX_SHORTCODE = '/{shortcode type="(.*?)"(.*?)}/i';

    private static $attributes = [
        'class' => ClassAttribute::class
    ];

    private static $styles = [];
    private static $shortcodes = [];

    static function addAttribute(string $name, string $class) : bool
    {
        self::$attributes[$name] = $class;
        return true;
    }

    static function getAttribute(string $name) : bool|string
    {
        if(!self::hasAttribute($name))
        {
            return false;
        }

        return self::$attributes[$name];
    }

    static function removeAttribute(string $name) : bool
    {
        if(!self::hasAttribute($name))
        {
            return false;
        }

        unset(self::$attributes[$name]);
        return true;
    }

    static function hasAttribute(string $name) : bool
    {
        return isset(self::$attributes[$name]);
    }

    static function addStyle(string $name, string $class) : bool
    {
        self::$styles[$name] = $class;
        return true;
    }

    static function getStyle(string $name) : bool|string
    {
        if(!self::hasStyle($name))
        {
            return false;
        }

        return self::$styles[$name];
    }

    static function removeStyle(string $name) : bool
    {
        if(!self::hasStyle($name))
        {
            return false;
        }

        unset(self::$styles[$name]);
        return true;
    }

    static function hasStyle(string $name) : bool
    {
        return isset(self::$styles[$name]);
    }

    static function addShortCode(string $type, string $class) : bool
    {
        self::$shortcodes[$type] = $class;
        return true;
    }

    static function getShortCode(string $type) : bool|string
    {
        if(!isset(self::$shortcodes[$type]))
        {
            return false;
        }

        return self::$shortcodes[$type];
    }

    static function removeShortCode(string $type) : bool
    {
        if(!self::hasShortCode($type))
        {
            return false;
        }

        unset(self::$shortcodes[$type]);
        return true;
    }

    static function hasShortCode(string $type) : bool
    {
        return isset(self::$shortcodes[$type]);
    }

    static function loadHTML(string $source, HtmlElement $result)
    {
        libxml_use_internal_errors(true);

        $dom = new \DOMDocument('1.0', 'UTF-8');
        $source = preg_replace('/>[\s]+</', '><', $source);

        $dom->loadHTML(mb_convert_encoding(
            $source, 'HTML-ENTITIES', 'UTF-8'), LIBXML_HTML_NODEFDTD
        );

        $items = $dom->getElementsByTagName('body');
        self::parseDOMElement($result, $items->item(0));

        return $result;
    }

    protected static function parseDOMElement(
        HtmlElement $result, \DOMElement $element)
    {
        $attrs = self::getAttributes($element);

        if($result instanceof ShortCodeInterface
            && ($data = $attrs->getArray()))
        {
            $result->loadOptions($data);
        }
        else if($data = $attrs->getArray())
        {
            $result->loadAttributes($data);
        }

        foreach($element->childNodes as $child_node)
        {
            if($child_node instanceof \DOMText)
            {
                $result->append($child_node->data);
            }
            else if($child_node instanceof \DOMElement)
            {
                $child = self::createChildElement(
                    $child_node, $result
                );

                self::parseDOMElement($child, $child_node);
            }
        }
    }

    protected static function createChildElement(
        \DOMElement $child, HtmlElement $html)
    {
        if($child->tagName !== 'shortcode')
        {
            return $html->appendCreateHtml($child->tagName);
        }

        if(!$type = $child->getAttribute('type'))
        {
            throw new AttributeTypeNotFound($child, 404);
        }

        if(!$class = self::getShortCode($type))
        {
            throw new ShortCodeNotFound($type, 404);
        }

        if(!class_exists($class))
        {
            throw new ShortCodeClassNotFound($class, 404);
        }

        $tagname = $child->getAttribute('tagname');
        $result = new $class(($tagname ?: 'div'));

        if(!$result instanceof ShortCodeInterface)
        {
            throw new ShortCodeImplement($result, 404);
        }

        if(!$result instanceof HtmlElement)
        {
            throw new ShortCodeExtends($result, 404);
        }

        $html->appendHtml($result);
        return $result;
    }

    protected static function getAttributes(\DOMElement $element)
    {
        $attributes = [];

        foreach($element->attributes as $attr)
        {
            $attributes[$attr->name] = $attr->value;
        }

        return new Attributes($attributes);
    }
}
