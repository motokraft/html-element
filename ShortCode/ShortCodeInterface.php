<?php namespace Motokraft\HtmlElement\ShortCode;

/**
 * @copyright   2022 motokraft. MIT License
 * @link https://github.com/motokraft/html-element
 */

interface ShortCodeInterface
{
    function loadOptions(array $options) : static;
    function getOption(string $name, $default = null);
    function removeOption(string $name) : bool;
    function hasOption(string $name) : bool;
}