<?php namespace Motokraft\HtmlElement\Exception;

/**
 * @copyright   2022 motokraft. MIT License
 * @link https://github.com/motokraft/html-element
 */

use \Motokraft\HtmlElement\Event\BaseEvent;

class EventExtends extends \Exception
{
    private $obj;

    function __construct(object $obj, int $code = 510)
    {
        $this->obj = $obj;

        $text = 'Class %s must be extends from %s';

        parent::__construct(sprintf($text,
            get_class($obj), BaseEvent::class
        ), $code);
    }

    function getObject() : object
    {
        return $this->obj;
    }
}