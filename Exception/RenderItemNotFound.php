<?php namespace Motokraft\HtmlElement\Exception;

/**
 * @copyright   2022 motokraft. MIT License
 * @link https://github.com/motokraft/html-element
 */

use \Motokraft\HtmlElement\HtmlElement;

class RenderItemNotFound extends \Exception
{
    private $type;
    private $element;

    function __construct(HtmlElement $element, int $code = 404)
    {
        $this->type = $element->getType();
        $this->element = $element;

        $text = 'Element name %s is missing output layout!';
        $message = sprintf($text, $this->type);

        parent::__construct($message, $code);
    }

    function getType() : null|string
    {
        return $this->type;
    }

    function getElement() : null|HtmlElement
    {
        return $this->element;
    }
}