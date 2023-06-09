<?php namespace Motokraft\HtmlElement\Exception\Type;

/**
 * @copyright   2022 motokraft. MIT License
 * @link https://github.com/motokraft/html-element
 */

use \Motokraft\HtmlElement\HtmlElement;

class TypeExtends extends \Exception
{
    function __construct(object $obj, int $code = 510)
    {
        $message = $this->getMessageText();
        $class = $this->getClassName();

        $message = vsprintf($message, [
            get_class($obj), $class
        ]);

        parent::__construct($message, $code);
    }

    protected function getMessageText() : string
    {
        return 'Class %s must be extends from %s';
    }

    protected function getClassName() : string
    {
        return HtmlElement::class;
    }
}