<?php namespace Motokraft\HtmlElement\Exception;

/**
 * @copyright   2022 motokraft. MIT License
 * @link https://github.com/motokraft/html-element
 */

class AttributeTypeNotFound extends \Exception
{
    private \DOMElement $element;

    function __construct(\DOMElement $element, int $code = 404)
    {
        $this->element = $element;

        $message = $this->getMessageText();
        $message = sprintf($message, $element->tagName);

        parent::__construct($message, $code);
    }

    function getElement() : \DOMElement
    {
        return $this->element;
    }

    protected function getMessageText() : string
    {
        return 'The type attribute for the %s is required!';
    }
}