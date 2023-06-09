<?php namespace Motokraft\HtmlElement\Exception;

/**
 * @copyright   2022 motokraft. MIT License
 * @link https://github.com/motokraft/html-element
 */

use \Motokraft\HtmlElement\HtmlElement;

class RenderItemNotFound extends \Exception
{
    private string $type;
    private HtmlElement $element;

    function __construct(HtmlElement $element, int $code = 404)
    {
        $this->type = $element->getType();
        $this->element = $element;

        $message = $this->getMessageText();
        $message = sprintf($message, $this->type);

        parent::__construct($message, $code);
    }

    function getType() : string
    {
        return $this->type;
    }

    function getElement() : HtmlElement
    {
        return $this->element;
    }

    protected function getMessageText() : string
    {
        return 'Element name %s is missing output layout!';
    }
}