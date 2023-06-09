<?php namespace Motokraft\HtmlElement\Exception\Style;

/**
 * @copyright   2022 motokraft. MIT License
 * @link https://github.com/motokraft/html-element
 */

class StyleClassNotFound extends \Exception
{
    private string $name;

    function __construct(string $name, int $code = 404)
    {
        $this->name = $name;

        $message = $this->getMessageText();
        $message = sprintf($message, $name);

        parent::__construct($message, $code);
    }

    function getName() : string
    {
        return $this->name;
    }

    protected function getMessageText() : string
    {
        return 'Style class "%s" not found!';
    }
}