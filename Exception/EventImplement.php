<?php namespace Motokraft\HtmlElement\Exception;

/**
 * @copyright   2022 motokraft. MIT License
 * @link https://github.com/motokraft/html-element
 */

use \Motokraft\HtmlElement\Event\EventInterface;

class EventImplement extends \Exception
{
    private $obj;

    function __construct(object $obj, int $code = 501)
    {
        $this->obj = $obj;

        $text = 'The %s class must implement the %s interface';

        parent::__construct(sprintf($text,
            get_class($obj), EventInterface::class
        ), $code);
    }

    function getObject() : object
    {
        return $this->obj;
    }
}