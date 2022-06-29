<?php namespace Motokraft\HtmlElement\Exception;

/**
 * @copyright   2022 motokraft. MIT License
 * @link https://github.com/motokraft/html-element
 */

class AttributeClassNotFound extends \Exception
{
    private $class;

    function __construct(string $class, int $code = 404)
    {
        $this->class = $class;

        $text = 'Attribute class %s not found!';
        $message = sprintf($text, $class);

        parent::__construct($message, $code);
    }

    function getClass() : null|string
    {
        return $this->class;
    }
}