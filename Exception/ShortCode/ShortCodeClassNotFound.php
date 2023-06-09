<?php namespace Motokraft\HtmlElement\Exception\ShortCode;

/**
 * @copyright   2022 motokraft. MIT License
 * @link https://github.com/motokraft/html-element
 */

class ShortCodeClassNotFound extends \Exception
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
        return 'Shortcode class "%s" not found!';
    }
}