<?php namespace Motokraft\HtmlElement\Renderer;

/**
 * @copyright   2022 motokraft. MIT License
 * @link https://github.com/motokraft/html-element
 */

use \Motokraft\Object\Traits\ObjectTrait;

abstract class AbstractRenderer implements RendererInterface
{
    use ObjectTrait;

    function __construct(array $data = [])
    {
        $this->loadArray($data);
    }
}