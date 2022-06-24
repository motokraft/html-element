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
    const SHORTCODE_DEFAULT_TAGNAME = 'div';

    const REGEX_SHORTCODE_1 = '/{shortcode(.*)}/i';
    const REGEX_SHORTCODE_2 = '/{(.*) shortcode="(.*?)"(.*?)}/i';
    const REGEX_SHORTCODE_3 = '/{(.*) type="shortcode" name="(.*?)"(.*?)}/i';

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

    static function addShortCode(string $name, string $class) : bool
    {
        self::$shortcodes[$name] = $class;
        return true;
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

    static function loadHTML(string $source, HtmlElement $result, bool $shortcode = true)
    {
        $source = preg_replace('/[\r\n]+/', '', $source);
        $source = preg_replace('/\s+/u', ' ', $source);
        $source = mb_convert_encoding($source, 'HTML-ENTITIES', 'UTF-8');

        if($shortcode)
        {
            if(preg_match(self::REGEX_SHORTCODE_1, $source))
            {
                $source = preg_replace(
                    self::REGEX_SHORTCODE_1, '<shortcode$1 />', $source
                );
            }

            if(preg_match(self::REGEX_SHORTCODE_2, $source))
            {
                $replacement = '<shortcode tagname="$1" type="$2"$3 />';

                $source = preg_replace(
                    self::REGEX_SHORTCODE_2, $replacement, $source
                );
            }

            if(preg_match(self::REGEX_SHORTCODE_3, $source))
            {
                $replacement = '<shortcode tagname="$1" type="$2"$3 />';

                $source = preg_replace(
                    self::REGEX_SHORTCODE_3, $replacement, $source
                );
            }
        }

        libxml_use_internal_errors(true);
        $dom = new \DOMDocument('1.0', 'UTF-8');

        $dom->loadHTML($source, LIBXML_HTML_NODEFDTD);

        $items = $dom->getElementsByTagName('body');
        self::parseDOMElement($result, $items->item(0), $shortcode);

        return $result;
    }

    private static function parseDOMElement(
        HtmlElement $result, \DOMElement $element, bool $shortcode = true)
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
                $result->append(trim($child_node->data));
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
}
