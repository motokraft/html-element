<?php namespace Motokraft\HtmlElement\Exception\Attribute;

/**
 * @copyright   2022 motokraft. MIT License
 * @link https://github.com/motokraft/html-element
 */

use \Motokraft\HtmlElement\Attributes\AttributeInterface;

class AttributeImplement extends \Exception
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
        return 'The %s class must implement the %s interface';
    }

    protected function getClassName() : string
    {
        return AttributeInterface::class;
    }
}