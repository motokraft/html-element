<?php namespace Motokraft\HtmlElement;

/**
 * @copyright   2022 motokraft. MIT License
 * @link https://github.com/motokraft/html-element
 */

abstract class HtmlParser
{
    final static function loadUrl(string $link) : bool|HtmlElement
    {
        if(!$source = file_get_contents($link))
        {
            return false;
        }

        return self::loadString($source);
    }

    final static function loadCURL(\CurlHandle $curl, bool $autoclose = true) : bool|HtmlElement
    {
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        if(!$source = curl_exec($curl))
        {
            if($autoclose) curl_close($curl);
            return false;
        }

        if($autoclose) curl_close($curl);
        return self::loadString($source);
    }

    final static function loadString(string $source) : HtmlElement
    {
        $source = preg_replace('/[\r\n]+/', '', $source);
        $source = preg_replace('/\s+/u', ' ', $source);
        $source = mb_convert_encoding($source, 'HTML-ENTITIES', 'UTF-8');

        libxml_use_internal_errors(true);

        $dom = new \DOMDocument('1.0', 'UTF-8');
        $dom->loadHTML($source, LIBXML_HTML_NODEFDTD);

        $element = $dom->documentElement;

        $tag = strval($element->tagName);
        $result = new HtmlElement($tag);

        self::parserDOMElement($element, $result);
        return $result;
    }

    private static function parserDOMElement(\DOMElement $element, HtmlElement $parent) : void
    {
        $length = $element->attributes->length;
        $attrs = [];

        for($i = 0; $i < $length; $i++)
        {
            $item = $element->attributes->item($i);
            $attrs[$item->name] = $item->value;
        }

        $parent->loadAttributes($attrs);

        foreach($element->childNodes as $child)
        {
            if($child instanceof \DOMText)
            {
                $parent->append($child->data);
            }
            else if($child instanceof \DOMElement)
            {
                $tag = (string) strval($child->tagName);
                $result = $parent->appendCreateHtml($tag);

                self::parserDOMElement($child, $result);
            }
        }
    }
}