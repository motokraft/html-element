<?php namespace Motokraft\HtmlElement\Exception;

/**
 * @copyright   2022 motokraft. MIT License
 * @link https://github.com/motokraft/html-element
 */

class AttributeTypeNotFound extends \Exception
{
    private $element;

    function __construct(\DOMElement $element, int $code)
    {
        $this->element = $element;

        $text = 'The type attribute for the %s is required!';
        $message = sprintf($text, $element->tagName);

        parent::__construct($message, $code);
    }

    function getElement() : \DOMElement
    {
        return $this->element;
    }
}