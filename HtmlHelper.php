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
use \Motokraft\HtmlElement\Exception\EventClassNotFound;
use \Motokraft\HtmlElement\Exception\EventImplement;
use \Motokraft\HtmlElement\Exception\EventExtends;
use \Motokraft\HtmlElement\Object\Attributes;
use \Motokraft\HtmlElement\Attributes\BaseAttribute;
use \Motokraft\HtmlElement\Attributes\ClassAttribute;
use \Motokraft\HtmlElement\Event\ObjectEvent;
use \Motokraft\HtmlElement\Event\BaseEvent;
use \Motokraft\HtmlElement\Event\EventInterface;

class HtmlHelper
{
    const SHORTCODE_DEFAULT_TAGNAME = 'div';

    private static $attributes = [
        'class' => ClassAttribute::class,
        '_default' => BaseAttribute::class
    ];

    private static $regex_schortcodes = [
        '/{shortcode(.*)}/i' => '<shortcode$1 />',
        '/{(.*) shortcode="(.*?)"(.*?)}/i' => '<shortcode tagname="$1" type="$2"$3 />',
        '/{(.*) type="shortcode" name="(.*?)"(.*?)}/i' => '<shortcode tagname="$1" type="$2"$3 />'
    ];

    private static $styles = [];
    private static $shortcodes = [];
    private static $events = [];
    private static $classes = [];

    static function addAttribute(string $name, string $class)
    {
        self::$attributes[$name] = $class;
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

    static function addRegexSchortCode(string $pattern, string $replacement)
    {
        self::$regex_schortcodes[$pattern] = $replacement;
    }

    static function getRegexSchortCode(string $pattern) : bool|string
    {
        if(!self::hasRegexSchortCode($pattern))
        {
            return false;
        }

        return self::$regex_schortcodes[$pattern];
    }

    static function removeRegexSchortCode(string $pattern) : bool
    {
        if(!self::hasRegexSchortCode($pattern))
        {
            return false;
        }

        unset(self::$regex_schortcodes[$pattern]);
        return true;
    }

    static function hasRegexSchortCode(string $pattern) : bool
    {
        return isset(self::$regex_schortcodes[$pattern]);
    }

    static function addStyle(string $name, string $class)
    {
        self::$styles[$name] = $class;
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

    static function addShortCode(string $name, string $class)
    {
        self::$shortcodes[$name] = $class;
    }

    static function getShortCode(string $name) : bool|string
    {
        if(!self::hasShortCode($name))
        {
            return false;
        }

        return self::$shortcodes[$name];
    }

    static function removeShortCode(string $name) : bool
    {
        if(!self::hasShortCode($name))
        {
            return false;
        }

        unset(self::$shortcodes[$name]);
        return true;
    }

    static function hasShortCode(string $name) : bool
    {
        return isset(self::$shortcodes[$name]);
    }

    static function addEventClass(string $name, string $class)
    {
        if(!self::hasEvent($name))
        {
            self::$events[$name] = [];
        }

        array_push(self::$events[$name], $class);
    }

    static function getEventClasses(string $name) : array
    {
        if(!self::hasEvent($name))
        {
            return [];
        }

        return self::$events[$name];
    }

    static function removeEvent(string $name) : bool
    {
        if(!self::hasEvent($name))
        {
            return false;
        }

        unset(self::$events[$name]);
        return true;
    }

    static function hasEvent(string $name) : bool
    {
        return isset(self::$events[$name]);
    }

    static function removeEventClass(string $name, string $class) : bool
    {
        if(!self::hasEventClass($name, $class))
        {
            return false;
        }

        $_events = self::getEventClasses($name);
        $key = array_search($class, $_events);

        if($key !== false)
        {
            unset($_events[$key]);
        }

        if(empty($_events))
        {
            self::removeEvent($name);
        }
        else
        {
            $_events = array_values($_events);
            self::$events[$name] = $_events;
        }

        return true;
    }

    static function hasEventClass(string $name, string $class) : bool
    {
        return in_array($class, self::getEventClasses($name));
    }

    static function dispatchEvent(ObjectEvent $event) : bool
    {
        $name = (string) $event->getName();

        if(!$_events = self::getEventClasses($name))
        {
            return false;
        }

        $method = $event->getMethodName();

        $filter_event = function (string $class) use (&$method)
        {
            $class = self::prepareEvent($class);
            return method_exists($class, $method);
        };

        if(!$_events = array_filter($_events, $filter_event))
        {
            return false;
        }

        $map_event = function (string $class) use (&$method, &$event)
        {
            $class = self::prepareEvent($class);
            return $class->{$method}($event);
        };

        $result = array_map($map_event, $_events);
        return !in_array(false, $result, true);
    }

    static function loadHTML(string $source, HtmlElement $result, bool $shortcode = true)
    {
        $source = preg_replace('/[\r\n]+/', '', $source);
        $source = preg_replace('/\s+/u', ' ', $source);
        $source = mb_convert_encoding($source, 'HTML-ENTITIES', 'UTF-8');

        if($shortcode)
        {
            $source = self::parseShortCode($source);
        }

        libxml_use_internal_errors(true);
        $dom = new \DOMDocument('1.0', 'UTF-8');

        $dom->loadHTML($source, LIBXML_HTML_NODEFDTD);
        $body = $dom->getElementsByTagName('body');

        if($body->item(0) instanceof \DOMElement)
        {
            self::parseDOMElement($result, $body->item(0), $shortcode);
        }

        return $result;
    }

    private static function parseShortCode(string $source) : string
    {
        foreach(self::$regex_schortcodes as $pattern => $replacement)
        {
            if(preg_match($pattern, $source))
            {
                $source = preg_replace($pattern, $replacement, $source);
            }
        }

        return $source;
    }

    private static function parseDOMElement(
        HtmlElement $result, \DOMElement $element, bool $shortcode)
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
                    $child_node, $result, $shortcode
                );

                self::parseDOMElement($child, $child_node, $shortcode);
            }
        }
    }

    private static function createChildElement(
        \DOMElement $child, HtmlElement $html, bool $shortcode) : HtmlElement
    {
        if($shortcode)
        {
            if($child->tagName === 'shortcode')
            {
                if(!$type = $child->getAttribute('type'))
                {
                    throw new AttributeTypeNotFound($child);
                }

                if(!$tagname = $child->getAttribute('tagname'))
                {
                    $tagname = self::SHORTCODE_DEFAULT_TAGNAME;
                }

                $child->removeAttribute('type');
                $child->removeAttribute('tagname');

                return self::createShortCode($type, $tagname, $html);
            }
            else if($type = $child->getAttribute('shortcode'))
            {
                if(!$tagname = $child->getAttribute('tagname'))
                {
                    $tagname = $child->tagName;
                }

                $child->removeAttribute('shortcode');
                return self::createShortCode($type, $tagname, $html);
            }
            else if($child->getAttribute('type') === 'shortcode')
            {
                $type = $child->getAttribute('name');

                if(!$tagname = $child->getAttribute('tagname'))
                {
                    $tagname = $child->tagName;
                }

                $child->removeAttribute('type');
                $child->removeAttribute('name');

                return self::createShortCode($type, $tagname, $html);
            }
        }

        return $html->appendCreateHtml($child->tagName);
    }

    private static function createShortCode(string $type,
        string $tagname, HtmlElement $html) : ShortCodeInterface
    {
        if(!$class = self::getShortCode($type))
        {
            throw new ShortCodeNotFound($type);
        }

        if(!class_exists($class))
        {
            throw new ShortCodeClassNotFound($class);
        }

        $result = new $class($tagname);

        if(!$result instanceof ShortCodeInterface)
        {
            throw new ShortCodeImplement($result);
        }

        if(!$result instanceof HtmlElement)
        {
            throw new ShortCodeExtends($result);
        }

        $html->appendHtml($result);
        return $result;
    }

    private static function getAttributes(\DOMElement $element)
    {
        $attributes = [];

        foreach($element->attributes as $attr)
        {
            $attributes[$attr->name] = $attr->value;
        }

        return new Attributes($attributes);
    }

    private static function prepareEvent(string $class) : EventInterface
    {
        if(isset(self::$classes[$class]))
        {
            return self::$classes[$class];
        }

        if(!class_exists($class))
        {
            throw new EventClassNotFound($class);
        }

        $result = new $class;

        if(!$result instanceof EventInterface)
        {
            throw new EventImplement($result);
        }

        if(!$result instanceof BaseEvent)
        {
            throw new EventExtends($result);
        }

        self::$classes[$class] = $result;
        return $result;
    }
}
