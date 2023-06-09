<?php namespace Motokraft\HtmlElement\Exception\Style;

/**
 * @copyright   2022 motokraft. MIT License
 * @link https://github.com/motokraft/html-element
 */

use \Motokraft\HtmlElement\Styles\AbstractStyle;

class StyleExtends extends \Exception
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
        return AbstractStyle::class;
    }
}