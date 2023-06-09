<?php namespace Motokraft\HtmlElement;

/**
 * @copyright   2022 motokraft. MIT License
 * @link https://github.com/motokraft/html-element
 */

use \Motokraft\HtmlElement\ShortCode\AbstractShortCode;
use \Motokraft\HtmlElement\Exception\ShortCode\ShortCodeNotFound;
use \Motokraft\HtmlElement\Exception\ShortCode\ShortCodeClassNotFound;
use \Motokraft\HtmlElement\Exception\ShortCode\ShortCodeImplement;
use \Motokraft\HtmlElement\Exception\ShortCode\ShortCodeExtends;
use \Motokraft\HtmlElement\Exception\AttributeTypeNotFound;
use \Motokraft\HtmlElement\Exception\FileNotReadable;
use \Motokraft\HtmlElement\Exception\FileContentEmpty;
use \Motokraft\HtmlElement\Attributes\StandartAttribute;
use \Motokraft\HtmlElement\Attributes\ClassAttribute;
use \Motokraft\HtmlElement\Styles\StandartStyle;
use \Motokraft\HtmlElement\Exception\Type\TypeClassNotFound;
use \Motokraft\HtmlElement\Exception\Type\TypeExtends;

abstract class HtmlHelper
{
    const SHORTCODE_DEFAULT_TAGNAME = 'div';

    private static array $attributes = [
        'class' => ClassAttribute::class,
        '_default' => StandartAttribute::class
    ];

    private static array $regex_schortcodes = [
        '/{shortcode(.*)}/i' => '<shortcode$1 />',
        '/{(.*) shortcode="(.*?)"(.*?)}/i' => '<shortcode tagname="$1" type="$2"$3 />',
        '/{(.*) type="shortcode" name="(.*?)"(.*?)}/i' => '<shortcode tagname="$1" type="$2"$3 />'
    ];

    private static array $types = [
        'base' => Types\HtmlBaseElement::class,
        'head' => Types\HtmlHeadElement::class,
        'link' => Types\HtmlLinkElement::class,
        'meta' => Types\HtmlMetaElement::class,
        'button' => Types\HtmlButtonElement::class,
        'fieldset' => Types\HtmlFieldSetElement::class,
        'embed' => Types\HtmlEmbedElement::class,
        'form' => Types\HtmlFormElement::class,
        'input' => Types\HtmlInputElement::class,
        'img' => Types\HtmlImageElement::class
    ];

    private static array $styles = [
        '_default' => StandartStyle::class
    ];

    private static array $shortcodes = [];
    private static array $classes = [];

    static function addTypeClass(string $name, string $class) : void
    {
        self::$types[$name] = $class;
    }

    static function getTypeClass(string $name) : bool|string
    {
        if(!self::hasTypeClass($name))
        {
            return false;
        }

        return self::$types[$name];
    }

    static function removeTypeClass(string $name) : bool
    {
        if(!self::hasTypeClass($name))
        {
            return false;
        }

        unset(self::$types[$name]);
        return true;
    }

    static function hasTypeClass(string $name) : bool
    {
        return isset(self::$types[$name]);
    }

    static function getTypeClasses() : array
    {
        return self::$types;
    }

    static function loadTypeClass(string $type, array $attrs = []) : HtmlElement
    {
        if(!$class = self::getTypeClass($type))
        {
            return new HtmlElement($type, $attrs);
        }

        if(!class_exists($class))
        {
            throw new TypeClassNotFound($class);
        }

        $result = new $class($attrs);

        if(!$result instanceof HtmlElement)
        {
            throw new TypeExtends($result);
        }

        return $result;
    }

    static function addAttribute(string $name, string $class) : void
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

    static function addRegexSchortCode(string $pattern, string $replacement) : void
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

    static function addStyle(string $name, string $class) : void
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

    static function addShortCode(string $name, string $class) : void
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

    static function loadFile(string $filepath,
        HtmlElement $element, bool $shortcode = true) : HtmlCollection
    {
        if(!is_readable($filepath))
        {
            throw new FileNotReadable($filepath);
        }

        if(!$html = file_get_contents($filepath))
        {
            throw new FileContentEmpty($filepath);
        }

        return self::loadHTML($html, $element, $shortcode);
    }

    static function loadHTML(string $source,
        HtmlElement $element, bool $shortcode = true) : HtmlCollection
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

        $xpath = new \DOMXPath($dom);
        $query = $xpath->query('body/*');

        $result = new HtmlCollection;

        foreach($query as $item)
        {
            $el = $element->appendCreateHtml($item->tagName);
            self::parseDOMElement($el, $item, $shortcode);

            $result->append($el);
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
        HtmlElement $result, \DOMElement $element, bool $shortcode) : void
    {
        $attrs = self::getAttributes($element);

        if($result instanceof AbstractShortCode
            && ($data = $attrs->getArrayCopy()))
        {
            $result->loadArray($data);
        }
        else if($data = $attrs->getArrayCopy())
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

                self::parseDOMElement(
                    $child, $child_node, $shortcode
                );
            }
        }
    }

    private static function createChildElement(
        \DOMElement $child, HtmlElement $html, bool $shortcode) : HtmlElement
    {
        if(!$shortcode)
        {
            return $html->appendCreateHtml($child->tagName);
        }

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

        return $html->appendCreateHtml($child->tagName);
    }

    private static function createShortCode(string $type,
        string $tagname, HtmlElement $html) : AbstractShortCode
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

        if(!$result instanceof AbstractShortCode)
        {
            throw new ShortCodeExtends($result);
        }

        $html->appendHtml($result);
        return $result;
    }

    private static function getAttributes(\DOMElement $element) : \ArrayIterator
    {
        $length = $element->attributes->length;
        $result = new \ArrayIterator;

        for($i = 0; $i < $length; $i++)
        {
            $item = $element->attributes->item($i);
            $result[$item->name] = $item->value;
        }

        return $result;
    }
}
