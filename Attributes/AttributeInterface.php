<?php namespace Motokraft\HtmlElement\Attributes;

/**
 * @copyright   2022 motokraft. MIT License
 * @link https://github.com/motokraft/html-element
 */

interface AttributeInterface
{
    function setValue(mixed $value) : void;
    function getName() : string;
    function getValue() : mixed;
    function render() : string;
    function __toString() : string;
}