<?php namespace Motokraft\HtmlElement\Traits;

/**
 * @copyright   2022 motokraft. MIT License
 * @link https://github.com/motokraft/html-element
 */

use \Motokraft\Object\Traits\ObjectTrait;
use \Motokraft\HtmlElement\HtmlElement;
use \Motokraft\HtmlElement\Renderer\BaseRenderer;
use \Motokraft\HtmlElement\Renderer\RendererInterface;
use \Motokraft\HtmlElement\Exception\RendererNotFound;
use \Motokraft\HtmlElement\Exception\RendererClassNotFound;
use \Motokraft\HtmlElement\Exception\RendererImplement;
use \Motokraft\HtmlElement\Exception\RendererExtends;

trait RendererTrait
{
    use ObjectTrait;

    private static $renderers = [];

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

    function getName() : null|string
    {
        return $this->get('name');
    }

    function getLayout() : null|string
    {
        return $this->get('layout', 'default');
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

        $renderer = new $renderer($this);

        if(!$renderer instanceof RendererInterface)
        {
            throw new RendererImplement($renderer);
        }

        if(!$renderer instanceof BaseRenderer)
        {
            throw new RendererExtends($renderer);
        }

        if(!empty($data))
        {
            $renderer->loadArray($data);
        }

        $renderer->set('layout', $layout);
        return $renderer;
    }
}