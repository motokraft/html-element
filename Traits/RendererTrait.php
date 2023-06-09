<?php namespace Motokraft\HtmlElement\Traits;

/**
 * @copyright   2022 motokraft. MIT License
 * @link https://github.com/motokraft/html-element
 */

use \Motokraft\Object\Traits\ObjectTrait;
use \Motokraft\HtmlElement\HtmlElement;
use \Motokraft\HtmlElement\Renderer\AbstractRenderer;
use \Motokraft\HtmlElement\Renderer\RendererInterface;
use \Motokraft\HtmlElement\Exception\Renderer\RendererNotFound;
use \Motokraft\HtmlElement\Exception\Renderer\RendererClassNotFound;
use \Motokraft\HtmlElement\Exception\Renderer\RendererImplement;
use \Motokraft\HtmlElement\Exception\Renderer\RendererExtends;

trait RendererTrait
{
    use ObjectTrait;

    final static function addRenderer(string $name, string $class) : void
    {
        self::$renderers[$name] = $class;
    }

    final static function getRenderer(string $name) : bool|string
    {
        if(!self::hasRenderer($name))
        {
            return false;
        }

        return self::$renderers[$name];
    }

    final static function removeRenderer(string $name) : bool
    {
        if(!self::hasRenderer($name))
        {
            return false;
        }

        unset(self::$renderers[$name]);
        return true;
    }

    final static function hasRenderer(string $name) : bool
    {
        return isset(self::$renderers[$name]);
    }

    final static function getRenderers() : array
    {
        return self::$renderers;
    }

    function getLayout() : ?string
    {
        return $this->get('layout');
    }

    function render(HtmlElement $element, array $data = []) : HtmlElement
    {
        $renderer = $this->loadRenderer($data);
        return $renderer->render($element);
    }

    final protected function loadRenderer(array $data = []) : RendererInterface
    {
        $layout = (string) $this->getLayout();

        if(!$renderer = self::getRenderer($layout))
        {
            throw new RendererNotFound($layout);
        }

        if(!class_exists($renderer))
        {
            throw new RendererClassNotFound($renderer);
        }

        $renderer = new $renderer($this, $data);

        if(!$renderer instanceof RendererInterface)
        {
            throw new RendererImplement($renderer);
        }

        if(!$renderer instanceof AbstractRenderer)
        {
            throw new RendererExtends($renderer);
        }

        return $renderer;
    }
}