<?php namespace Motokraft\HtmlElement\Exception;

/**
 * @copyright   2022 motokraft. MIT License
 * @link https://github.com/motokraft/html-element
 */

class ShortCodeClassNotFound extends \Exception
{
    private $type;

    function __construct(string $type, int $code = 404)
    {
        $this->type = $type;

        $text = 'Shortcode class "%s" not found!';
        $message = sprintf($text, $type);

        parent::__construct($message, $code);
    }

    function getType()
    {
        return $this->type;
    }
}