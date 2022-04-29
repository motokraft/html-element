<?php namespace Motokraft\HtmlElement\Exception;

/**
 * @copyright   2022 motokraft. MIT License
 * @link https://github.com/motokraft/html-element
 */

use \Motokraft\HtmlElement\ShortCode\ShortCodeInterface;

class ShortCodeImplement extends \Exception
{
    private $obj;

    function __construct(object $obj, int $code)
    {
        $this->obj = $obj;

        $text = 'The %s class must implement the %s interface';

        parent::__construct(sprintf($text,
            get_class($obj), ShortCodeInterface::class
        ), $code);
    }

    function getObject() : object
    {
        return $this->obj;
    }
}