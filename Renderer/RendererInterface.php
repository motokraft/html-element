<?php namespace Motokraft\HtmlElement\Renderer;

/**
 * @copyright   2022 motokraft. MIT License
 * @link https://github.com/motokraft/html-element
 */

use \Motokraft\HtmlElement\HtmlElement;

interface RendererInterface
{
    function render(HtmlElement $element) : HtmlElement;
}